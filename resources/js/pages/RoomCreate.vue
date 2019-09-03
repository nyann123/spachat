<template>
  <div id="app">
    <h1>roomcreate</h1>

    <form>
      <div class="form-group">
        <label for="room_name">ルーム名</label>
        <input v-model="room_name" :placeholder="this.$store.getters.getUser.name + 'の部屋'" type="text" class="form-control" :class="{ 'is-invalid': room_name_valid }" id="room_name">
        <small v-if="room_name_valid" class="invalid-feedback">最大文字数を超えています</small>
        <small class="text-muted">最大100文字まで入力できます</small>
      </div>

      <div class="form-group">
        <label for="password">パスワード</label>
        <input v-model="password" type="text" class="form-control" :class="{ 'is-invalid': password_valid }" id="password">
        <small v-if="password_valid" class="invalid-feedback">最大文字数を超えています</small>
        <small class="text-muted">パスワードを設定できます(任意)</small>
      </div>

     <button @click="create_room()" type="button" class="btn btn-primary col-md-2">作成する</button>
    </form>
    
  </div>
</template>

<script>
export default {

  data: function(){
    return{
      room_name: '',
      password: '',
      room_name_valid: false,
      password_valid: false
    }
  },
  watch:{
    room_name(){
      this.room_name_valid = this.room_name.length > 100 ? true :false
    },
    password(){
      this.password_valid = this.password.length > 100 ? true :false
    }
  },
  methods:{

    create_room(){
      if(!this.room_name_valid && !this.password_valid){

        const url = 'ajax/room';
        const params = {  room_name: this.room_name || this.$store.getters.getUser.name + 'の部屋',
                          user: this.$store.getters.getUser,
                          password: this.password || ''
                          };                
        axios.post(url, params)
          .then((response) => {
            
        // 成功したら作成したチャットルームに移動
        this.$router.push( '/ChatRoom/' + response.data );
       }); 
      }
    }
  }
}
</script>