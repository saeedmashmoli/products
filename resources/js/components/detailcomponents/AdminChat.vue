<template>
    <div>
        <div class="panel panel-primary">
            <div class="panel-collapse">
                <div class="panel-body">
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
                                <button @click="attachFile" class="btn btn-warning btn-sm m-0" title="ارسال فایل"><i class="fa fa-paperclip"></i></button>
                                <button @click="sendMessage" class="btn btn-info btn-sm m-0" title="ارسال"><i class="fa fa-send"></i></button>
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    export default {
        name: "AdminChat",
        data(){
          return {
              text : '',
              url: '',
          }
        },
        computed : {
            ...mapState(['messages' , 'authUser'])
        },
        methods : {
            submitFile(){
                let formData = new FormData();
                formData.append('file', this.$refs.file.files[0]);
                formData.append('chatId' ,this.$store.state.chatId);
                axios.post( '/admin/sendMessageByAdmin',
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

                    axios.post('/admin/sendMessageByAdmin',{ chatId : this.$store.state.chatId ,text , url : this.url })
                        .then(response => {})
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
        max-height: 400px;
        overflow:auto;
    }
    .panel-footer{
        bottom: 2%;
        position: absolute;
        width: 94%;
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
