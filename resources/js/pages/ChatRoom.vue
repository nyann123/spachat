<template>
    <div v-show="!$store.getters.getLoading" id="app">

      <div v-if="room_timelimit">
        <div style="opacity:1; max-width:700px;" class="toast mb-2 text-center mx-auto">
          <div class="toast-body bg-secondary text-white">
            このチャットルームは終了しています <br>　新たな書き込みはできません
          </div>
        </div>
      </div>
      
      <div id="log" :style="{ height: this.content_height + 'px' }" style="overflow:auto">
        <div v-for="m in messages">

          <!-- 通知 -->
          <div v-if="m.isNotification">
            <div style="opacity:1; max-width:300px;" class="toast mb-2 text-center mx-auto">
             <div class="toast-body bg-secondary text-white">
                <p style="white-space: pre-line;" class="m-0">{{ m.message }}</p>
             </div>
           </div>
          </div>

          <!-- チャット -->
          <div v-else>
            <div class="d-flex" :class="($store.getters.getUser.id === m.user_id ) ? 'justify-content-end' : 'justify-content-start'">
              <div style="opacity:1; max-width:700px;" class="toast mb-2">
                <div class="toast-header">
                  <strong class="mr-auto">{{ m.user_name }}</strong>
                  <small class="ml-2">{{ m.created_at | moment("from", "now") }}</small>
                </div>
                <div class="toast-body" >
                  <p style="white-space: pre-line;" class="m-0">{{ m.message }}</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <form v-if="!room_timelimit">
        <textarea v-model="message" class="form-controll col" rows="2" type="text" style="resize:none;"></textarea>
        <button class="btn btn-primary col"  type="button" @click="send()">送信</button>
      </form>
    </div>
</template>



<script>
export default {
  data: function() {
    return {
      room_id: this.$route.params.id,
      room_timelimit: false,
      message: '',
      messages: [],
      content_height: 0,
    }
  },
  methods: {   
    //  メッセージ送信
    send() {
      const self = this;

      //  入力されているか確認
      if (this.message){

        const user = this.$store.getters.getUser;
        const url ='ajax/isEntering';
        const params = {  user_id : user.id,
                          room_id: this.$route.params['id'],
                         }
        axios.post(url, params)
          .then((response) => {

          //  チャットルームに入室していればメッセージ送信処理へ  
          if(response.data){

            const url = 'ajax/chat';
            const params = {  message: this.message,
                              room_id: this.room_id,
                              user_id: user.id,
                              user_name: this.$store.getters.getUser.name,
                              };
            axios.post(url, params)
              .then((response) => {
                
                // メッセージをクリア
                this.message = '';

                //  チャットルームが時間切れの場合
                if(response.data){
                  self.$router.push('/top');
                }
              });
            }
        })
      }
    },

    //  メッセージ取得
    getMessages() {
      const self = this;
      const url ='ajax/chat';
      const params = { room_id: this.room_id };
      axios.get(url, {params})
        .then((response) => {

        this.messages = response.data;

        //  一番下までスクロールされていれば追従
        const log = this.$el.querySelector("#log");
        if(log.scrollHeight - log.clientHeight === log.scrollTop){
          self.scrollToEnd();
        }

        self.$store.commit("setLoading", false);
      });
    },

    //　コンテンツのサイズ調整
    handleResize() {
      this.content_height = window.innerHeight -  96/* form */ - 62/* header */ - 13 /* 調整 */;
    },

    //  一番下までスクロール
    scrollToEnd() {
      const log = this.$el.querySelector("#log");
      Vue.nextTick(function() {
        log.scrollTo(0, log.scrollHeight)
      })
    },

    //  チャットルームの制限時間内か確認する
    isTimeLimit(){
      const self = this;
      const url ='ajax/roomlimit';
      const params = { room_id: this.room_id };
      axios.post(url, params)
        .then((response) => {

          if(response.data){
            self.room_timelimit = true;
          }

      })
    },
    
    setup() {
      this.$store.commit("setLoading", true);

      this.handleResize();
      this.getMessages();
      this.isTimeLimit();
      window.addEventListener('resize', this.handleResize);

      // 30秒毎に実行するように
      const self = this;
      this.interval = setInterval(function () {
        self.$forceUpdate();
        self.isTimeLimit();
      }, 1000 * 30);


      Echo.channel('chat')
      .listen('MessageCreated', (e) => {

        this.getMessages(); // 全メッセージを再読込

      });
    }
  },
    mounted() {
      this.setup();
    },

    //　ページ移動前に更新解除
    beforeDestroy () {
      clearInterval(this.interval)
    },
    
    //　urlを書き換えたら移動
    beforeRouteUpdate (to, from, next) {
      next('/top');
    },
}
</script>