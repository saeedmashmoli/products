<template>
    <div class="col-lg-12 main">
        <div v-if="isLoading" class="col-lg-9 float-right showVideo">
            <div class="col-12 p-0">
                <video class="w-100" controls>
                    <source   :src="video.videoUrl" type="video/mp4">
                </video>
            </div>
            <div class="col-12 float-right pt-3 pr-0">
                <h4>{{ video.title }}</h4>
                <div class="float-right text-secondary mt-2 mb-2 myIcons">
                    <i class="fa fa-thumbs-up "></i> {{video.like_count}}
                    <i class="fa fa-thumbs-down mr-2"></i> {{video.dis_like_count}}
                    <i class="fa fa-eye mr-2"></i> {{video.view_count}}
                    <i id="myLike" :class="`fa mr-3 ${likeStatus ? 'fa-heart' : 'fa-heart-o'}`" @click="likeVideo"></i>
                </div>
            </div>
            <router-link v-for="product in products" :key="product.id" :to="`/product/${product.slug}`">#{{product.title}}</router-link>
            <p class="videoBody">{{video.text}}</p>
        </div>
        <div v-if="isLoading" class="col-lg-3 float-right mr-lg-6">
            <div class="mainVideos">
                <div v-for="video in videos" class="card bg-dark text-white">
                    <router-link :to="`/video/${video.slug}`" @click.native="getVideo" class="text-white">
                        <img class="card-img" :src="video.picUrl" :alt="video.url">
                        <div class="card-img-overlay">
                            <h5 class="card-title">{{video.title}}</h5>
                            <p class="card-text">{{video.text.slice(0,100)}} ...</p>
                            <div class="float-right w-100">
                                <p class="mt-2 text-white float-right"><small>{{video.publish_date}}</small></p>
                                <div class="float-left text-white mt-2">
                                    <i class="fa fa-thumbs-up mr-1"></i> {{video.like_count}}
                                    <i class="fa fa-thumbs-down mr-1"></i> {{video.dis_like_count}}
                                    <i class="fa fa-eye"></i> {{video.view_count}}
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
            <nav v-if="videoLastPage > 1" class="paginate-nav" aria-label="Page navigation">
                <div class="mt-12">
                    <b-pagination-nav
                        v-model="currentPage"
                        :number-of-pages="videoLastPage"
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
        name: "SingleVideo",
        data(){
            return{
                isLoading : false,
                currentPage : 1,
                likeStatus : false,
            }
        },
        computed : {
            ...mapState(['video', 'videos' , 'products' , 'videoLastPage']),
        },
        methods : {
            likeVideo(){
                $('#myLike').toggleClass('fa-heart');
                $('#myLike').toggleClass('fa-heart-o');
                this.likeStatus = !this.likeStatus;
                axios.post('/likeVideo' , {video_id : this.$store.state.video.id})
                    .then(response => {
                        this.$store.commit('changeVideo',response.data);
                    })
                    .catch(err => console.log(err))
            },
            pageChangeHandler() {
                this.getVideo()
            },
            linkGen(){},
            getVideo(){
                axios.post('/getVideo',{slug : this.$route.params.slug , page : this.currentPage})
                    .then( response => {
                        if(response.data === false){
                            this.$router.push('/notFoundPage')
                        }else {
                            this.likeStatus = response.data.likeStatus;
                            this.$store.commit('changeVideoLastPage', response.data.videos.last_page);
                            this.$store.commit('changeVideo', response.data.video);
                            this.$store.commit('changeVideos', response.data.videos.data);
                            this.$store.commit('changeProducts', response.data.video.products);
                            this.isLoading = true
                        }
                    })
                    .catch( err => console.log(err))
            },
        },
        beforeMount() {
            this.getVideo();
        },
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
    .showVideo{
        margin: 2% 0 0 0;
    }
    .mainVideos{
        margin : 10px 0;
        border: 1px solid #aaa;
        padding: 2% 1%;
        border-radius: 5px;
        background: #17a2b8;
    }
    #vjs_video_3{
        margin : auto !important
    }
    .main{
        direction: rtl;
        padding: 0 2%;
    }
    .videoBody{
        padding: 2%;
    }
    .card{
        border-radius: 5px;
        margin : 2% 10% 0 10%;
    }
</style>
