import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store/index'

// ページコンポーネントをインポートする
import ChatRoom from './pages/ChatRoom.vue'
import Top from './pages/Top.vue'
import Entry from './pages/Entry.vue'
import RoomCreate from './pages/RoomCreate.vue'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/ChatRoom/:id',
    component: ChatRoom,
  },
  {
    path: '/Top',
    component: Top,

  },
  {
    path: '/',
    component: Entry,
    meta: {isEntry: true} 
  },
  {
    path: '/RoomCreate',
    component: RoomCreate
  },
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  routes
})

router.beforeEach((to, from, next) => {

  store.commit("setLoading", true);
  const user = store.getters.getUser

  //　アクセス制限
  //  名前が未設定なら設定ページへ
  
  if(!user.name || !user.id){
    if(to.path !== '/'){
      next({ path: '/'})
    }else{
      next();
    }
  }else{
    next();
  }

  // //  入室した部屋のみ入れるように
  if(to.params.id){
    const url ='ajax/isEntering';
    const params = {  user_id : user.id,
                      room_id: to.params.id,
                     }
                     console.log(params);
    axios.post(url, params)
      .then((response) => {
        console.log(response);
      if(response.data){
        next();
      }else{
        next('/Top')
      }
    })
      
  }

})

router.afterEach(() => {
  store.commit("setLoading", false);
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router