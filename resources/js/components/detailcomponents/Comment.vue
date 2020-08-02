<template>
    <div>
        <div v-if="authUser" class="col-lg-12 float-right main">
            <textarea class="form-control myTextArea" placeholder="متن نظر را بنویسید" v-model="text"></textarea>
            <button class="btn btn-secondary btn-sm myButton" @click="sendComment">ارسال نظر</button>
        </div>
        <div v-if="!authUser" class="col-lg-12 float-right mt-5 main">
            <h6 class="text-danger">برای ارسال نظر بایستی وارد شوید!!!</h6>
            <div class="col-lg-12">
                <div class="col-lg-4">
                    <input v-model="username" placeholder="نام کاربری؟" class="form-control">
                </div>
                <div class="col-lg-4 pt-2 float-right">
                    <input v-model="password" type="password" placeholder="رمز عبور؟" class="form-control">
                </div>
                <div class="col-lg-2 pt-2 float-right">
                     <button @click="loginUser" class="btn btn-danger btn-sm float-right">ورود</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {mapState} from 'vuex'

    export default {
        name: "Comment",
        props : ['commentId'],
        data(){
            return {
                text : '',
                parent_id : '',
                username : '',
                password : ''
            }
        },
        computed : {
            ...mapState(['authUser'])
        },
        methods : {
            loginUser(){
                axios.post('/loginUser' , {username : this.username , password : this.password})
                    .then( response => {
                        if(response.data === 'Wrong User'){
                            Swal.fire('','رمز عبور اشتباه است','warning')
                        }else if(response.data === 'Status Failed'){
                            Swal.fire('','کاربر مورد نظر غیر فعال شده است','warning')
                        }else{
                            this.$store.commit('changeAuthUser' , response)
                        }
                    })
                    .catch(err => console.log(err))
            },
            sendComment(){
                if(this.text.length > 3 ){
                    axios.post('/sendComment' , {
                        text : this.text,
                        user_id : this.$store.state.authUser.id,
                        product_id : this.$store.state.product.id,
                        parent_id : this.$store.state.selectCommentId
                    })
                        .then( response => {
                            this.$store.commit('changeSelectCommentId' , 0);
                            Swal.fire('','نظر شما با موفقیت ثبت شد. پس از تایید مدیریت نمایش داده خواهد شد','success')
                        })
                        .catch( err => console.log(err))
                }else{
                    Swal.fire('','متن وارد شده بایستی بیشتر از سه کاراکتر باشد','error')
                }
            }
        }
    }
</script>

<style scoped>
    .myTextArea{
        background: rgba(0,0,0,.1) !important;
    }
    .main{
        border: 1px solid #aaa;
        background: #ddd;
        padding: 2% !important;
        border-radius : 5px
    }
    .myButton{
        margin-top : 2%;
        float : left
    }
    @media screen and (max-width: 640px) {
        .myTextArea{
            height: 50px;
        }
        .main{
            padding: 5% !important;
        }
    }
    .myTextArea{
        margin-top: 1%;
        height: 120px;
    }
</style>
