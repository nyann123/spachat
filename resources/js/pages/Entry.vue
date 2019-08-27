<template>
  <div if="app">
    <h1>Entry</h1>
    <form>
      <div class="form-group">
        <label for="name">名前</label>
        <input v-model="name" type="text" class="form-control" :class="{ 'is-invalid': name_valid }" id="name">
        <small v-if="name_valid" class="invalid-feedback">最大文字数を超えています</small>
        <small class="text-muted">最大15文字</small>
      </div>
      <button @click="entry()" type="button" class="btn btn-primary">Submit</button>
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
      this.name_valid = this.name.length > 15 ? true :false
    }
  },
  methods: {   

    entry() {
      if(!this.name_valid){

        this.$store.commit('stateInit');
        const url = 'ajax/entry';
        const params = { name: this.name };
        axios.post(url, params)
          .then((response) => {
  
        // 成功したらページ移動
        this.$store.commit({type:'setUser', name: this.name, id:response.data});
        this.$router.push('Top');
       });
      }
    }
  },
}
</script>