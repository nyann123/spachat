<template>
<div id="app">
  <div class="headar pb-1">

    <div v-if="histry">
      <RouterLink to="/roomcreate" class="btn btn-outline-primary mr-2">
        新しい部屋を作る
      </RouterLink>
      <button @click="getRoom()" class="btn btn-outline-primary float-right">部屋一覧</button>
    </div>

    <div v-else>
      <RouterLink to="/roomcreate" class="btn btn-outline-primary mr-2">
        新しい部屋を作る
      </RouterLink>
      <button @click="getRoom()" class="btn btn-outline-primary">更新する</button>
      <button @click="getRoomHistry()" class="btn btn-outline-primary float-right">履歴</button>
    </div>

    <form>
      <div class="form-group pt-1 m-0">
        <input v-model="search_word" type="text" class="form-control" placeholder="検索する">
      </div>
    </form>

  </div>

  <div v-if="!$store.getters.getLoading" class="card-group" :style="{ height: this.content_height + 'px' }" style="overflow:auto">
    <div v-for="room in filteredRooms" class="col-lg-4 pb-2 p-0"  style="box-sizing:border-box">
      <div class="card mr-1">
        <div class="card-body position-relative">
          <font-awesome-icon v-if="room.password" icon="lock" class="position-absolute" style="top:5px; left:5px;" />
          <h5 class="card-title">{{ room.room_name }}</h5>
          <p class="card-text"><small>部屋主: {{ room.host_user }}</small></p>
        </div>
        <div class="card-footer bg-white">
          <button @click="isPassword(room)" class="btn btn-primary col-lg-8 d-block mx-auto">入室</button>
        </div>
      </div>
    </div>
  </div>

  <!-- モーダル -->
  <Modal @close="closeModal" v-if="modal">
    <p>パスワードを入力してください</p>
    <input v-model="input_password" :class="{ 'is-invalid': input_password_valid }" class="form-control" type="text">
    <small v-if="input_password_valid" class="invalid-feedback">パスワードが間違っています</small>

    <template slot="footer">
      <button @click="passwordAuth()" class="btn btn-primary col-lg-2">送信</button>
    </template>
  </Modal>
</div>

</template>


<script>
import Modal from '../components/Modal.vue'

export default {
  components: { Modal },

  data: function(){
    return{
      search_word: '',
      chat_rooms: [],
      content_height: 0,
      modal: false,
      histry: false,
      input_password: '',
      input_password_valid: false,
      choice_room: '',
    }
  },
  computed: {
    filteredRooms() { 
        var data = this.chat_rooms;
        var search_word = this.search_word && this.search_word.toLowerCase();
        if(search_word) {
            data = data.filter(function (row) {
                return Object.keys(row).some(function () {
                    return String(row.room_name).toLowerCase().indexOf(search_word) > -1
                })
            })
        }
        return data;
    }
  },
  methods: {

    //  チャットルームを取得する
    getRoom() {
      this.histry = false;
      this.$store.commit("setLoading", true);

      const url ='ajax/room';
      axios.get(url)
        .then((response) => {

        this.chat_rooms = response.data;

        this.$store.commit("setLoading", false);
      });
    },

    //  過去に入室したことのあるチャットルームを取得する
    getRoomHistry(){
      this.histry = true;
      this.$store.commit("setLoading", true);

      const url ='ajax/roomHistry';
      const params ={user_id: this.$store.getters.getUser.id};
      axios.post(url, params)
        .then((response) => {
        
        this.chat_rooms = response.data;

        this.$store.commit("setLoading", false);
      });
    },

    //  パスワードが設定されているか確認する
    isPassword(room) {
      this.choice_room = room;
      if(room.password){
        this.openModal()
      }else{
        this.enterRoom();
      }
    },

    //  チャットルームへの入室処理
    enterRoom(){
      const self = this;
      const url ='ajax/enterroom';
      const params ={ user_id: this.$store.getters.getUser.id,
                      room_id: this.choice_room.id,
                      }
      axios.post(url, params)
        .then((response) => {
        self.$router.push('/chatroom/' + this.choice_room.id)
        })
    },

    //  パスワード認証
    passwordAuth(){
      if(this.input_password){

        const self = this;
        const url ='ajax/roomauth';
        const params ={ password: this.input_password,
                        hash: this.choice_room.password
                        }

        axios.post(url, params)
          .then((response) => {

          if(response.data){
            self.enterRoom();
          }else{
            self.input_password_valid = true;
          }

        })
      }
    },

    //　コンテンツのサイズ調整
    handleResize() {
      const head_height = this.$el.querySelector(".headar").clientHeight
      this.content_height = window.innerHeight - head_height - 75;
    },

    openModal() {
      this.modal = true
    },

    closeModal() {
      this.modal = false
      this.input_password = ''
      this.input_password_valid = false
    },

  },

  mounted(){
    this.getRoom();

    this.handleResize();
    window.addEventListener('resize', this.handleResize);

  }
}
</script>