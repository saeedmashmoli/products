<template>
    <div class="col-12">
        <myCarousel></myCarousel>
        <my-products></my-products>
        <my-articles></my-articles>
        <my-videos></my-videos>
    </div>

</template>

<script>
    import myCarousel from "../components/detailcomponents/Carousel";
    import myArticles from "../components/detailcomponents/Articles";
    import myProducts from "../components/detailcomponents/Products";
    import myVideos from "../components/detailcomponents/Videos";

    export default {
        name: "Home",
        data(){
            return{

            }
        },
        components : {
            myCarousel,
            myArticles,
            myProducts,
            myVideos
        }
    }
</script>

<style scoped>
    .pagination{
        padding: 0 !important;
    }
</style>
