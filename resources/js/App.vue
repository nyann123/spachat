<template>
  <div>
    <header>
      <Navbar />
    </header>
    <main>
      <div class="container" style="margin-top:70px; position:relative;">
        <RouterView />
      </div>
      <div v-show="$store.state.common.loading" class="container">
        <Loading />
      </div>
    </main>
  </div>
</template>

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