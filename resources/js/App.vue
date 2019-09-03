<template>
  <div>
    <header>
      <Navbar />
    </header>
    <main>
      <div class="container pl-1 pr-1" style="margin-top:70px; position:relative;">
        <RouterView />
      </div>
      <div v-show="$store.state.common.loading" class="container">
        <Loading />
      </div>
    </main>
  </div>
</template>

// スクロールバー
<style lang="scss">
::-webkit-scrollbar{
  width: 10px;
}
::-webkit-scrollbar-track{
  background: #fff;
  border: none;
  border-radius: 10px;
  box-shadow: inset 0 0 2px #777; 
}
::-webkit-scrollbar-thumb{
  background: #ccc;
  border-radius: 10px;
  box-shadow: none;
}

</style>

<script>
import Navbar from './components/Navbar.vue'
import Loading from './components/Loading.vue'

export default {
  components: {
    Navbar,
    Loading
  }
}
</script>