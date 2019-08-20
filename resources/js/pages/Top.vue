<template>
<div id="app">
  <div class="headar pb-3">
    <h1>Top</h1>
    <RouterLink to="/roomcreate" class="btn btn-outline-primary mr-3">
      新しい部屋を作る
    </RouterLink>
    <button @click="getchatroom()" class="btn btn-outline-primary">更新する</button>
  </div>
  <div class="row" :style="{ height: this.content_height + 'px' }" style="overflow: auto;" v-if="!$store.getters.getLoading">
    <div class="col-lg-4 pb-2" v-for="room in chat_rooms">
      <div class="card">
        <div class="card-body position-relative">
          <font-awesome-icon v-if="room.password" icon="lock" class="position-absolute" style="top:5px; left:5px;" />
          <h5 class="card-title">{{ room.room_name }}</h5>
          <p class="card-text"><small>部屋主: {{ room.host_user }}</small></p>
        </div>
        <div class="card-footer bg-white d-flex">
          <button @click="enterroom(room)" class="btn btn-primary col-8">入室</button>
          <!-- <p class="col-4 text-center">0/20人</p> -->
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
      <button @click="password_auth()" class="btn btn-primary col-lg-2">送信</button>
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
      chat_rooms: [],
      content_height: 0,
      modal: false,
      input_password: '',
      input_password_valid: false,
      choice_room: '',
    }
  },
  methods: {
    getchatroom() {

      this.$store.commit("setLoading", true);

      const url ='ajax/room';
      axios.get(url)
        .then((response) => {

        this.chat_rooms = response.data;

        this.$store.commit("setLoading", false);
      });
    },

    enterroom(room) {
      if(room.password){
        this.choice_room = room;
        this.openModal()
      }else{
        this.$router.push('/chatroom/' + room.id)
      }
    },

    password_auth(){
      if(this.input_password){

        const self = this;
        const url ='ajax/roomauth';
        const params ={ password: this.input_password,
                        hash: this.choice_room.password
                        }

        axios.post(url, params)
          .then((response) => {

            if(response.data){
              this.$router.push('/chatroom/' + this.choice_room.id)
            }else{
              self.input_password_valid = true;
            }

        })
      }
    },

    //　コンテンツのサイズ調整
    handleResize() {
      const head_height = this.$el.querySelector(".headar").clientHeight
      this.content_height = window.innerHeight - this.$store.getters.getHeader_height - head_height - 15;
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
    this.getchatroom();

    this.handleResize();
    window.addEventListener('resize', this.handleResize);

  }
}
</script>