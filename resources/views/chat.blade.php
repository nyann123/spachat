<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
<body class="bg-cyan">
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <!-- <div class="container"> -->
      <a class="navbar-brand" href="#">spaChat</a>
    <!-- </div> -->
  </nav>
  <div class="container">
    <div id="chat">
      <textarea v-model="message"></textarea>
      <br>
      <button type="button" @click="send()">送信</button>

      <div v-for="m in messages">
        <!-- 登録された日時 -->
        <span v-text="m.created_at"></span>：&nbsp;

        <!-- メッセージ内容 -->
        <span v-text="m.message"></span>
      </div>
    </div>
  </div>


  <script>

      new Vue({
          el: '#chat',
          data: {
              message: '',
              messages: []
          },
          methods: {   
            send() {

              const url = 'ajax/chat';
              const params = { message: this.message };
              axios.post(url, params)
                .then((response) => {

              // 成功したらメッセージをクリア
              this.message = '';
            });
          },

          getMessages() {

            const url ='ajax/chat';
            axios.get(url)
              .then((response) => {

              this.messages = response.data;

            });
          }
        },
        mounted() {

          this.getMessages();

          Echo.channel('chat')
          .listen('MessageCreated', (e) => {

            this.getMessages(); // 全メッセージを再読込

          });
        }   
      });

  </script>
</body>
</html>