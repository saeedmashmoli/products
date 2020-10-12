<template>
    <div>
        <div class="col-md-3 myChat">
            <div class="panel panel-primary">
                <div @click="toggleChat" class="panel-heading" id="accordion">
                    <span class="glyphicon glyphicon-comment"></span>
                </div>
                <div v-if="authUser" :class="`panel-collapse showChat ${!isChat ? 'hideChat' : ''}`">
                    <div class="panel-body" style="height : 150px;max-height: 150px;overflow: auto">
                        <ul class="chat" id="chat">
                            <li v-for="message in messages" :class="`clearfix ${message.user_id === authUser.id ? 'rightMessage' : 'leftMessage'}`">
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font text-info">{{message.user_id === authUser.id ? 'من' : message.user.username}}</strong>
                                    </div>
                                    <p v-if="message.text !== null" class="mr-2 mb-0">{{message.text}}</p>
                                    <a v-else-if="message.text === null" :href="message.url" target="_blank">مشاهده فایل</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <div class="input-group">
                            <input @keyup.enter="sendMessage" v-model="text" type="text" class="form-control input-md" placeholder="پیامی را بنویسید ..." />
                            <input @change="submitFile" type="file" id="file" ref="file" style="display: none">
                            <span class="btn-group">
                                <button @click="attachFile" class="btn btn-warning btn-md m-0" title="ارسال فایل"><i class="fa fa-paperclip"></i></button>
                                <button @click="sendMessage" class="btn btn-info btn-md m-0" title="ارسال"><i class="fa fa-send"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div v-if="!authUser" style="padding: 2%" :class="`col-lg-12 float-right mt-1 mb-1 main showChat ${!isChat ? 'hideChat' : ''}`">
                    <h6 class="text-danger text-center">بایستی وارد شوید!!!</h6>
                    <div class="col-lg-12">
                        <div class="col-lg-6 m-auto">
                            <input v-model="username" placeholder="نام کاربری؟" class="form-control">
                        </div>
                        <div class="col-lg-6 pt-2 m-auto">
                            <input v-model="password" type="password" placeholder="رمز عبور؟" class="form-control">
                        </div>
                        <div class="col-lg-6 pt-2 m-auto">
                            <button @click="loginUser" class="btn btn-danger btn-sm m-auto">ورود</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    export default {
        name: "Chat",
        data() {
            return {
                isChat : false,
                text : '',
                url: '',
                username : '',
                password : ''
            }
        },
        computed : {
            ...mapState(['messages' , 'authUser']),
        },
        beforeMount() {
            if (this.$store.state.authUser){
                this.getChat();
            }
        },
        mounted() {
            if (this.$store.state.authUser){
                Echo.private('getMessage.'+this.$store.state.authUser.id)
                    .listen('GetMessageEvent',()=>{
                        this.getChat();
                    }) ;
            }

        },
        methods: {
            getChat(){
                axios.post('getChat')
                    .then(response => {
                        this.$store.commit('changeChatId' , response.data.id);
                        this.$store.commit('changeMessages' , response.data.messages);
                    })
            },
            loginUser(){
               axios.post('/loginUser' , {username : this.username , password : this.password})
                    .then( response => {
                        if(response.data === 'Wrong User'){
                            Swal.fire('','رمز عبور اشتباه است','warning')
                        }else if(response.data === 'Status Failed'){
                            Swal.fire('','کاربر مورد نظر غیر فعال شده است','warning')
                        }else{
                            this.$store.commit('changeAuthUser' , response.data);
                            this.getChat();
                            setTimeout( ()=>{
                                Echo.private('getMessage.'+this.$store.state.authUser.id)
                                    .listen('GetMessageEvent',() => {
                                        this.getChat();
                                    }) ;
                            }, 1000)
                        }
                    })
                    .catch(err => console.log(err))
            },
            toggleChat(){
                this.isChat = !this.isChat;
                $('.showChat').slideToggle(200);
            },
            submitFile(){
                let formData = new FormData();
                formData.append('file', this.$refs.file.files[0]);
                formData.append('chatId' ,this.$store.state.chatId);
                axios.post( '/sendMessage',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                    .then(response => {
                        this.$store.commit('addToMessages',response.data)
                    })
                    .catch( err => console.log(err))
            },
            attachFile(){
                $('#file').trigger('click');
            },
            sendMessage(){
                if(this.text.length > 2){
                    let text = this.text;
                    this.text = '';
                    this.$store.commit('addToMessages' , {
                        user_id : this.$store.state.authUser.id,
                        chatId : this.$store.state.chatId,
                        text,
                        url : this.url
                    });
                    axios.post('/sendMessage',{ chatId : this.$store.state.chatId ,text, url : this.url })
                        .then(response => {
                            this.$store.commit('changeChatId',response.data.chat_id)
                        })
                        .catch( err => console.log(err))
                }else{
                    Swal.fire('','لطفا پیامی را بنویسید','warning')
                }

            }
        }
    }
</script>

<style scoped>
    .myChat{
        position: fixed;
        bottom: 0;
        left: 3px;
        direction : rtl;
        z-index: 9999;
        background: #ccc;
        border-radius: 5px;
        padding: 0;
    }
    .fa-paperclip{
        font-size: 20px;
        color: #495057;
        font-weight : bolder;
    }
    .panel-body{
        max-height: 200px;
        overflow:auto;
    }
    li{
        list-style: none;
    }
    .leftMessage{
        padding : 2% 0 0 2%;
        text-align: left;
    }
    .rightMessage{
        padding : 2% 2% 0 0;
        text-align: right;
    }
    .chat-img img{
        border-radius: 50%;
    }
    .hideChat{
        display : none
    }
    .panel-heading{
        background: #17a2b8;
        height: 30px;
        color: #ffff;
        padding: 0 2%;
        line-height: 35px;
        border-radius: 5px;
        cursor: pointer;
    }
    .panel-heading:hover{
        background: #96c2c9;
    }
</style>
