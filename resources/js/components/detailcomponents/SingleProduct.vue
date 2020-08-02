<template>
    <div class="col-lg-12 main">
        <div v-if="isLoading" class="col-lg-9 float-right showProduct">
            <div class="col-12 float-right">
                <h4>{{ product.title }}</h4>
                <div class="float-right text-secondary mt-2 mb-2 myIcons">
                    <i class="fa fa-thumbs-up"></i> {{product.like_count}}
                    <i class="fa fa-thumbs-down mr-2"></i> {{product.dis_like_count}}
                    <i class="fa fa-eye mr-2"></i> {{product.view_count}}
                    <i id="myLike" :class="`fa  mr-3 ${likeStatus ? 'fa-heart' : 'fa-heart-o'}`" @click="likeProduct"></i>
                </div>
            </div>
            <p class="productBody">{{product.text}}</p>
            <div class="mb-5 float-right">
                <gallery :images="galleries" :index="selectImage" @close="selectImage = null"></gallery>
                <div
                    class="image"
                    v-for="(image, imageIndex) in galleries"
                    :key="imageIndex"
                    @click="selectImage = imageIndex"
                    :style="{ backgroundImage: 'url(' + image + ')', width: '300px', height: '200px' }"
                ></div>
            </div>
            <div class="col-12">
                <my-comments></my-comments>
            </div>

        </div>
        <div v-if="isLoading" class="col-lg-3 float-right mr-lg-6"  >
            <div class="mainProducts">
                <div v-for="product in products" class="card bg-dark text-white">
                    <router-link :to="`/product/${product.slug}`" @click.native="getProduct" class="text-white">
                        <img class="card-img" :src="product.url" :alt="product.url">
                        <div class="card-img-overlay">
                            <h5 class="card-title">{{product.title}}</h5>
                            <p class="card-text">{{product.text.slice(0,100)}} ...</p>
                            <div class="float-right w-100">
                                <p class="mt-2 text-white float-right"><small>{{product.created_at}}</small></p>
                                <div class="float-left text-white mt-2">
                                    <i class="fa fa-thumbs-up mr-1"></i> {{product.like_count}}
                                    <i class="fa fa-thumbs-down mr-1"></i> {{product.dis_like_count}}
                                    <i class="fa fa-eye"></i> {{product.view_count}}
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
            <nav v-if="productLastPage > 1" class="paginate-nav" aria-label="Page navigation">
                <div class="mt-12">
                    <b-pagination-nav
                        v-model="currentPage"
                        :number-of-pages="productLastPage"
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
    import VueGallery from 'vue-gallery';
    import {mapState} from 'vuex';
    import myComment from './Comment';
    import myComments from './Comments';

    export default {
        name: "SingleProduct",
        data(){
            return{
                isLoading : false,
                currentPage : 1,
                selectImage: null,
                likeStatus : false,
                ip : '',
            }
        },
        components:{
            'gallery': VueGallery,
            myComment,
            myComments
        },
        computed : {
            ...mapState([ 'product' , 'galleries','products' , 'productLastPage']),
        },
        methods : {
            likeProduct(){
                $('#myLike').toggleClass('fa-heart');
                $('#myLike').toggleClass('fa-heart-o');
                this.likeStatus = !this.likeStatus;
                axios.post('/likeProduct' , {product_id : this.$store.state.product.id})
                    .then(response => {
                        this.$store.commit('changeProduct',response.data);
                    })
                    .catch(err => console.log(err))
            },
            pageChangeHandler() {
                this.getProduct()
            },
            linkGen(){},
           getProduct(){
                axios.post('/getProduct',{slug : this.$route.params.slug , page : this.currentPage})
                    .then( response => {
                        if(response.data === false){
                            this.$router.push('/notFoundPage')
                        }else {
                            this.likeStatus = response.data.likeStatus;
                            this.$store.commit('changeGalleries', response.data.product.galleries);
                            this.$store.commit('changeProductLastPage', response.data.products.last_page);
                            this.$store.commit('changeProduct', response.data.product);
                            this.$store.commit('changeComments', response.data.product.comments);
                            this.$store.commit('changeProducts', response.data.products.data);
                            this.isLoading = true
                        }
                    })
                    .catch( err => console.log(err))
            }
        },
        beforeMount() {
            this.getProduct()
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
    .showProduct{
        margin: 2% 0 0 0;
    }
    .image {
        float: left;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        border: 1px solid #ebebeb;
        margin: 5px;
        border-radius : 5px;
        cursor : pointer
    }
    .mainProducts{
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
    .productBody{
        padding: 2%;
    }
    .card{
        border-radius: 5px;
        margin : 2% 10% 0 10%;
    }
</style>
