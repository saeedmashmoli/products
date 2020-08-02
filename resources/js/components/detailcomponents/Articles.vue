<template>
    <div class="container">
        <h4>مقالات</h4>
        <div class="divider"></div>
        <div v-if="!isLoading" class="main">
            <div v-for="(article,index) in articles" class="card" style="width: 18rem;">
                <img class="card-img-top" :src="article.url" alt="Card image cap">
                <div class="card-body">
                    <h6 class="card-title">{{article.title}}</h6>
                    <p class="card-text" v-html="`${article.body.slice(0,100)}...`"></p>
                    <router-link :to="`/article/${article.slug}`" class="mt-2 mb-2">مشاهده</router-link>
                    <div class="float-right w-100">
                        <p class="mt-2 float-right"><small class="text-muted">{{article.publish_date}}</small></p>
                        <div class="float-left text-secondary mt-2">
                            <i class="fa fa-thumbs-up mr-1"></i> {{article.like_count}}
                            <i class="fa fa-thumbs-down mr-1"></i> {{article.dis_like_count}}
                            <i class="fa fa-eye"></i> {{article.view_count}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="isLoading" class="main isLoadingMain text-center mt-3">
            <h5>در حال بارگذاری</h5>
            <img src="/loading.gif">
        </div>
        <div v-if="articleLastPage > 1" class="divider"></div>
        <nav v-if="articleLastPage > 1" class="paginate-nav" aria-label="Page navigation">
            <div class="mt-12">
                <b-pagination-nav
                    pills
                    v-model="selectPage"
                    :number-of-pages="articleLastPage"
                    :link-gen="linkGen"
                    @input="pageChangeHandler"
                    last-number
                ></b-pagination-nav>
            </div>
        </nav>
    </div>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        name: "Articles",
        data(){
            return{
                isLoading : false,
                selectPage : 1
            }
        },
        computed : {
            ...mapState(['articles' , 'articleLastPage']),
        },
        methods : {
            pageChangeHandler() {
                this.getData()
            },
            linkGen(){ },
            getData(flag){
                this.isLoading = true;
                axios.post('/getAllArticles' , { 'page' :this.selectPage ,'categories' : this.$store.state.selectCategories})
                    .then((response) => {
                        this.$store.commit('changeArticleLastPage' ,response.data.last_page) ;
                        this.$store.commit('changeArticles',response.data.data) ;
                    })
                    .catch(error => console.log(error));
                setTimeout(() => {
                    this.isLoading = false
                }, 1500)
            }
        },
        beforeMount() {
            this.getData(false);
        }
    }
</script>

<style scoped>
     .container{
         margin: 2% 0 0 0;
         max-width : none;
         float: right
     }
    .card{
        float : right;
        direction: rtl;
        margin: 0.5%;
        height: 430px;
    }
     .card img{
         height: 220px;
     }
     @media screen and (max-width: 640px){
         .card img{
             height: 200px;
         }
         .container{
             margin-top: 5%;
         }
     }
    .card-body{
        padding-bottom : 0
    }
    .card-text{
        height: 70px;
    }
    .divider{
        height: 0.5px;
        background: #000;
        width: 100%;
        float: right;
    }
    .paginate-nav{
        float: right;
        width: 100%;
        margin: 1% 0 0 0;
        direction: rtl;
        text-align: center;
    }
    .main{
        width: 100%;
        margin: 2% 1%;
        float: right;
        direction: rtl;
    }

     .paginate-nav ul {
         padding : 0 !important
    }
</style>
