<template>
  <div id="app">
    <nav class="navbar fixed-top bg-white shadow-sm">
      <RouterLink class="navbar__brand" to="/top">
        <strong>SpaChat</strong>
      </RouterLink>
      <div class="navbar__menu">
        <span class="navbar__item">
          {{ username }} 
        </span>
        <div class="navbar__item text-center">
          <RouterLink class="button button--link" to="/">
            名前を変更する
          </RouterLink>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
  export default{
    computed: {

      username (){
        return this.$store.getters.getUser.name
      }

    },
  }
</script>