<template>
    <div class="w-100">
        <input class="form-control w-100" placeholder="دنبال چی میگردی؟" type="text" v-model="searchInput" @keyup="getResults">
        <div class="panel-footer" >
            <ul class="list-group">
                <li  v-for="product in searchProducts"  class="list-group-item w-100" @click="changeRoute('product')">
                    <router-link :to="`/product/${product.slug}`" >{{product.title}} <i class="fa fa-product-hunt productIcon"></i></router-link>
                </li>
                <li  v-for="article in searchArticles" @click="changeRoute('article')" class="list-group-item">
                    <router-link :to="`/article/${article.slug}`" >{{article.title}} <i class="fa fa-address-book articleIcon"></i></router-link>
                </li>
                <li  v-for="video in searchVideos" @click="changeRoute('video')" class="list-group-item">
                    <router-link :to="`/video/${video.slug}`" >{{video.title}} <i class="fa fa-video-camera videoIcon"></i></router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        name: "Search",
        data(){
            return {
                searchInput : '',
                searchVideos : [],
                searchArticles : [],
                searchProducts : [],
            }
        },
        computed : {
            ...mapState(['articles' , 'products' , 'article' , 'product' , 'video' , 'user' , 'galleries' ])
        },
        methods : {
            getResults(){
                if(this.searchInput.length > 3){
                    axios.post('/searchResult',{ 'title' : this.searchInput })
                        .then((response) => {
                            this.searchVideos = response.data.videos;
                            this.searchArticles = response.data.articles;
                            this.searchProducts = response.data.products;
                        });
                }
            },
            changeRoute(routeType){
                let route = this.$route.path.split('/');
                if(routeType === route[1]){
                    if(routeType === 'article'){
                        axios.post('/getArticle',{slug : this.$route.params.slug , page : this.$store.currentPage})
                            .then( response => {
                                this.$store.commit('changeUser',response.data.article.user);
                                this.$store.commit('changeArticle',response.data.article);
                                this.$store.commit('changeProducts',response.data.article.products);
                            })
                            .catch( err => console.log(err))
                    }else if(routeType === 'product'){
                        axios.post('/getProduct',{slug : this.$route.params.slug , page : this.$store.currentPage})
                            .then( response => {
                                this.$store.commit('changeGalleries',response.data.product.galleries);
                                this.$store.commit('changeProduct',response.data.product);
                            })
                            .catch( err => console.log(err))
                    }else if(routeType === 'video'){
                        axios.post('/getVideo',{slug : this.$route.params.slug , page : this.$store.currentPage})
                            .then( response => {
                                this.$store.commit('changeVideo',response.data.video);
                                this.$store.commit('changeProducts',response.data.video.products);
                            })
                            .catch( err => console.log(err))
                    }
                }
                this.searchInput = '';
                this.searchVideos = [];
                this.searchProducts = [];
                this.searchArticles = [];
            }
        }
    }
</script>

<style scoped>
    .list-group-item a{
        color: black;
        width: 100%;
        display: block;
        text-decoration: none;
    }
    .list-group-item{
        background : #ccc;
    }
    .list-group{
        position: absolute;
        z-index: 999;
        width: 100%;
    }
    .list-group-item i{
        float: left;
    }
    .articleIcon{
        color: blue;
    }
    .productIcon{
        color: green;
    }
    .videoIcon{
        color: rebeccapurple;
    }
</style>
