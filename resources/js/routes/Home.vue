<template>
    <div class="col-12">
        <myCarousel></myCarousel>
        <my-products></my-products>
        <my-articles></my-articles>
        <my-videos></my-videos>
        <div v-if="isChat">
            <my-chat></my-chat>
        </div>
        <my-chat></my-chat>
    </div>

</template>

<script>
    import myCarousel from "../components/detailcomponents/Carousel";
    import myArticles from "../components/detailcomponents/Articles";
    import myProducts from "../components/detailcomponents/Products";
    import myVideos from "../components/detailcomponents/Videos";
    import myChat from "../components/detailcomponents/Chat";
    export default {
        name: "Home",
        data(){
            return{
                isChat : false
            }
        },
        created() {

        },
        components : {
            myCarousel,
            myArticles,
            myProducts,
            myVideos,
            myChat
        }
    }
</script>

<style scoped>
    .pagination{
        padding: 0 !important;
    }
    .hideChat{
        position: fixed;
        bottom: 0;
        height: 30px;

    }
</style>
