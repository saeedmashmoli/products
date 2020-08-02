<template>
    <footer>
        <footer class="footer float-right w-100">
                <div class="footer-top">
                    <div class="col-lg-6 float-right">
                        <h6 class="title text-center m-0">درباره ما</h6>
                        <div class="divider"></div>
                        <p v-if="about && about.aboutUs" class="body">{{about.aboutUs}}</p>
                    </div>
                    <div class="col-lg-6 float-right">
                        <h6 class="title text-center m-0">ارتباط با ما</h6>
                        <div class="divider"></div>
                        <div class="group">
                            <div class="body">
                                <ul>
                                    <li v-if="about && about.email"><i class="fa fa-envelope"></i> ایمیل :‌ {{about.email}}</li>
                                    <li v-if="about && about.mobile"><i class="fa fa-phone"></i> شماره تماس :‌ {{about.mobile}}</li>
                                    <li>
                                        <div class="aboutIcons">
                                            <a v-if="about && about.whatsUp" :href="about.whatsUp" rel="me"><i class="fa fa-whatsapp"></i></a>
                                            <a v-if="about && about.instagram" :href="about.instagram" rel="me"><i class="fa fa-instagram"></i></a>
                                            <a v-if="about && about.telegram" :href="about.telegram" rel="me"><i class="fa fa-telegram"></i></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </footer>
    </footer>
</template>

<script>
    export default {
        name: "Footer",
        data(){
            return{
                about:{}
            }
        },
        created() {
            axios.get('/aboutMeData')
                .then((response) => this.about = response.data)
                .catch(error => console.log(error));
        },
    }
</script>

<style scoped>
 .footer{
     position: relative;
     z-index: 10;
     line-height: 2;
     padding: 25px 0 0;
     background: #4d545d;
     color: #fff;
     direction: rtl;
 }
    .mainFooterTopDiv{
        float: right;
        margin: 0.5% 1%;
    }
    .footerBottomRight,.footerBottomLeft{
        display: inline-block;
    }
    li{
        list-style : none;
    }
    .body,.description{
        padding-right: 5%;
    }
    .divider{
        background: #aaa;
        height: 1px;
        display: inline-block;
        width: 100%;
    }
    .aboutIcons{
        font-size: 25px;
    }
    .aboutIcons a {
        color: #aaa;
    }
</style>
