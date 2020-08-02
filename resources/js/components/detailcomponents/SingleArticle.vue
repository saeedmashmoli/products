<template>
    <div class="col-lg-12 main">
        <div v-if="isLoading" class="col-lg-9 float-right showArticle">
            <div class="col-12 float-right">
                <h4 >{{ article.title }}</h4>
                <div class="float-right text-secondary mb-2 mb-2 myIcons">
                    <i class="fa fa-thumbs-up"></i> {{article.like_count}}
                    <i class="fa fa-thumbs-down mr-2"></i> {{article.dis_like_count}}
                    <i class="fa fa-eye mr-2"></i> {{article.view_count}}
                    <i id="myLike" :class="`fa mr-3 ${likeStatus ? 'fa-heart' : 'fa-heart-o'}`" @click="likeArticle"></i>
                </div>
            </div>
            <h6>نوشته شده توسط: {{user.username}} ({{article.publish_date}})</h6>
            <router-link v-for="product in products" :key="product.id" :to="`/product/${product.slug}`">#{{product.title}}</router-link>
            <p class="articleBody" v-html="article.body"></p>
        </div>
        <div v-if="isLoading" class="col-lg-3 float-right mr-lg-6">
            <div class="mainArticles">
                <div v-for="article in articles" class="card bg-dark text-white">
                    <router-link :to="`/article/${article.slug}`" @click.native="getArticle" class="text-white">
                        <img class="card-img" :src="article.url" :alt="article.url">
                        <div class="card-img-overlay">
                            <h5 class="card-title">{{article.title}}</h5>
                            <p class="card-text" v-html="`${article.body.slice(0,100)}...`"></p>
                            <div class="float-right w-100">
                                <p class="mt-2 text-white float-right"><small>{{article.publish_date}}</small></p>
                                <div class="float-left text-white mt-2">
                                    <i class="fa fa-thumbs-up mr-1"></i> {{article.like_count}}
                                    <i class="fa fa-thumbs-down mr-1"></i> {{article.dis_like_count}}
                                    <i class="fa fa-eye"></i> {{article.view_count}}
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
            <nav v-if="articleLastPage > 1" class="paginate-nav" aria-label="Page navigation">
                <div class="mt-12">
                    <b-pagination-nav
                        pills
                        v-model="currentPage"
                        :number-of-pages="articleLastPage"
                        :link-gen="linkGen"
                        @input="pageChangeHandler"
                        last-number
                    ></b-pagination-nav>
                </div>
            </nav>
        </div>
        <div v-else-if="!isLoading" class="main isLoadingMain text-center mt-3">
            <h5>در حال بارگذاری</h5>
            <img src="/loading.gif">
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        name: "SingleArticle",
        data(){
            return{
                currentPage : 1,
                isLoading : false,
                likeStatus : false
            }
        },
        computed : {
            ...mapState(['article' , 'user' , 'articles' , 'products' , 'articleLastPage']),
        },
        methods : {
            likeArticle(){
                $('#myLike').toggleClass('fa-heart');
                $('#myLike').toggleClass('fa-heart-o');
                this.likeStatus = !this.likeStatus;
                axios.post('/likeArticle' , {article_id : this.$store.state.article.id})
                .then(response => {
                    this.$store.commit('changeArticle',response.data);
                })
                .catch(err => console.log(err))
            },
            pageChangeHandler() {
                this.getArticle(true);
            },
            linkGen(){},
           getArticle(){
                axios.post('/getArticle',{slug : this.$route.params.slug , page : this.currentPage})
                    .then( response => {
                        if(response.data === false){
                            this.$router.push('/notFoundPage')
                        }else{
                            this.likeStatus = response.data.likeStatus;
                            this.$store.commit('changeArticleLastPage',response.data.articles.last_page);
                            this.$store.commit('changeUser',response.data.article.user);
                            this.$store.commit('changeArticle',response.data.article);
                            this.$store.commit('changeArticles',response.data.articles.data);
                            this.$store.commit('changeProducts',response.data.article.products);
                            this.isLoading = true;
                        }
                    })
                    .catch( err => console.log(err))
            }
        },
        beforeMount() {
            this.getArticle();
        }
    }
</script>

<style scoped>
    @media screen and (max-width : 640px){
        .main{
            margin-top : 20px
        }
    }
    #myLike{
        font-size : 25px;
        cursor : pointer
    }
    #myLike:hover{
        color: red;
    }
    .paginate-nav{
        margin-top: 3%;
    }
    .showArticle{
        margin: 2% 0 0 0;
    }
    .myIcons{
        font-size: medium;
        padding: 2% 2% 0;
    }
    .mainArticles{
        margin-top : 10px;
        border: 1px solid #aaa;
        padding: 2% 1%;
        border-radius: 5px;
        background: #17a2b8;
    }
    .main{
        direction: rtl;
        padding: 0 2%;
    }
    .articleBody{
        padding: 2%;
    }
    .paginate-nav{
        margin-top: 3%;
    }
    .card{
        border-radius: 5px;
        margin : 2% 10% 0 10%;
    }
</style>
