<template>
    <div class="col-12">
        <div class="col-lg-3 show-chats">
            <div v-for="chat in chats" :class="`col-12 chat-detail ${chatId === chat.id ? 'active' : ''}`" @click="showChat(chat)">
                <span class="font-weight-bold">{{chat.user.username}}</span>
                <h5 v-if="chat.unread_messages_count > 0" class="float-left"><span class="badge badge-pill badge-info float-left">{{chat.unread_messages_count}}</span></h5>
                <p class="m-0" v-if="chat.messages[chat.messages.length-1].text">
                    {{chat.messages[chat.messages.length-1].text.slice(0,20)}}
                    {{chat.messages[chat.messages.length-1].text.length > 20 ? '...' : ''}}
                </p>
                <a v-if="!chat.messages[chat.messages.length-1].text" :href="chat.messages[chat.messages.length-1].url">مشاهده فایل</a>
            </div>
        </div>
        <div class="show-messages col-lg-9">
            <div v-if="isChat">
                <my-chat></my-chat>
            </div>
            <div v-else-if="!isChat" class="container">
                <h5>گپی برای نمایش انتخاب نشده</h5>
            </div>
        </div>
    </div>
</template>

<script>
    import myChat from  './AdminChat';
    import {mapState} from 'vuex';
    export default {
        name: "AdminChats",
        components:{
            myChat
        },
        computed : {
            ...mapState(['chatId' , 'chats'])
        },
        data(){
            return {
                isChat : false ,
            }
        },
        methods: {
            getChats(){
                axios.get('getChats')
                    .then( response => {
                        this.$store.commit('changeChats',response.data);
                    })
            },
            showChat(chat){
                this.$store.commit('changeChatId',chat.id);
                if (chat.unread_messages_count > 0){
                    this.$store.commit('changeChatsSeen',chat.id);
                }
                axios.post('getChat',{chatId :chat.id})
                    .then(response => {
                        this.$store.commit('changeMessages',response.data);
                    })
                .catch( err => console.log(err));
                setTimeout( ()=>{
                    this.isChat = true
                },100)
            }
        },
        beforeMount() {
            this.getChats()
        },
        created() {
            Echo.channel('sentMessage')
                .listen('SentMessageEvent' , () =>{
                    this.getChats();
                    axios.post('getChat',{chatId : this.$store.state.chatId})
                        .then(response => {
                            this.$store.commit('changeMessages',response.data)
                        })
            })
        }
    }
</script>

<style scoped>
    @media screen and (max-width: 400px){
        .show-chats ,.show-messages{
            float : none !important;
            height: 250px !important;
            max-height: 250px !important;
            overflow : auto !important;
        }
        .show-chats{
            height: 120px !important;
        }
    }
    .show-chats{
        border-left: 1px solid #ccc;
        background: #eee;
    }
    .show-messages{
        width: 100%;
        background: #ddd;
        text-align: center;
    }
    .show-chats ,.show-messages{
        float: right;
        width: 100%;
        height: 500px;
        max-height: 500px;
        border-radius: 5px;
        padding: 2% 0;
    }
    .chat-detail{
        padding: 2%;
        border-bottom: 1px solid #ccc;
        cursor: pointer;
    }
    .chat-detail:hover{
        background: #ddd;
    }
    .chat-detail.active{
        background: #ddd;
    }

</style>
