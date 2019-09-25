<template>
  <div if="app">
    <!-- <h1>Entry</h1> -->
    <form>
      <div class="form-group">
        <label for="name">使用する名前を入力してください</label>
        <input v-model="name" type="text" class="form-control" :class="{ 'is-invalid': name_valid }" id="name">
        <small v-if="name_valid" class="invalid-feedback">{{this.name_valid}}</small>
        <small class="text-muted">最大15文字</small>
      </div>
      <button @click="entry()" type="button" class="btn btn-primary col-md-2">決定</button>
    </form>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      name: '',
      name_valid: false,
    }
  },
  watch:{
    name(){
      if(this.name.length > 15 ){
        this.name_valid = '最大文字数を超えています';
      }else{
        this.name_valid = false;
      }
    }
  },
  methods: {   

    entry() {
      if(this.name){
        if(!this.name_valid){
  
          const url = 'ajax/entry';
          const params = { user_name: this.name,
                           user_id: this.$store.getters.getUser.id || '',
                           };
          axios.post(url, params)
            .then((response) => {
    
          // 成功したらページ移動
          this.$store.commit({type:'setUser', name: this.name, id:response.data});
          this.$router.push('Top');
         });
        }
      }
    }
  },
}
</script>