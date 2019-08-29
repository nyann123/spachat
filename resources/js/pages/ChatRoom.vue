<template>
    <div id="app">
      <div id="log" :style="{ height: this.content_height + 'px' }" style="overflow: auto;">
        <div v-for="m in messages">
          <div class="d-flex" :class="($store.getters.getUser.id === m.user_id ) ? 'justify-content-end' : 'justify-content-start'">
            <div style="opacity:1; max-width:700px;" class="toast mb-2">
              <div class="toast-header">
                <strong class="mr-auto">{{ m.user_name }}</strong>
                <small class="ml-2">{{ m.created_at | moment("from", "now") }}</small>
              </div>
              <div class="toast-body" ref="hogehoge">
                {{ m.message }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <form class="footer">
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
      message: '',
      messages: [],
      content_height: 0
    }
  },
  methods: {   
    //  メッセージ送信
    send() {
      if (this.message){
        const url = 'ajax/chat';
        const params = {  message: this.message,
                          room_id: this.room_id,
                          user_id: this.$store.getters.getUser.id,
                          user_name: this.$store.getters.getUser.name,
                          };
        axios.post(url, params)
          .then((response) => {
  
        // 成功したらメッセージをクリア
        this.message = '';
      });
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

        self.scrollToEnd();
      });
    },

    //　コンテンツのサイズ調整
    handleResize: function() {
      this.content_height = window.innerHeight - /* なぜか崩れるのでとりあえず固定値(96) this.$el.querySelector('.footer').clientHeight */ 96 - 85;
    },

    //一番下までスクロール
    scrollToEnd() {    	
      var log = this.$el.querySelector("#log");
      Vue.nextTick(function() {
        log.scrollTo(0, log.scrollHeight)
      })
    },
    
    setup() {
      this.handleResize();
      this.getMessages();
      this.scrollToEnd();

      window.addEventListener('resize', this.handleResize);

      // 30秒毎に更新
      const self = this;
      this.interval = setInterval(function () {
        self.$forceUpdate();
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