<template>
    <div class="main">
        <div class="col-lg-3 float-right mb-3">
            <b-card no-body header="دسته بندی ها">
                <b-card-body>
                    <ul id="myUL">
                        <li v-for="(category) in filterCategories" >
                            <input :id="`parentCheckbox${category.id}`" type="checkbox" @click="getFilterData(category.id , null)">
                            <span :id="`parentSpan${category.id}`" :class="category.child_category.length > 0 ? 'caret' : 'withoutChild'" @click="showChild(category.id)">
                                {{category.title}}
                            </span>
                            <ul :id="`nested${category.id}`" class="nested">
                                <li v-for="(childCategory,index) in category.child_category">
                                    <input :id="`childCheckBox${childCategory.id}`" type="checkbox" @click="getFilterData(childCategory.id , childCategory.parent_id)">
                                    <span class="withoutChild">{{childCategory.title}}</span>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </b-card-body>
            </b-card>
        </div>
        <div class="col-lg-9 float-right">
            <div v-if="filterProducts.length > 0" class="mainCarousel">
                <div id="carouselProducts" class="carousel slide mainCarousel" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li v-for="(product,index) in filterProducts" data-target="#carouselProducts" :data-slide-to="index" v-model="activeCarousel" :class="index === activeCarousel ? 'active' : ''"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div v-for="(product,index) in filterProducts" :key="index" :class="`carousel-item ${index === activeCarousel ? 'active' : ''}`">
                            <img  :src="product.url" class="carouselImage" :alt="product.url">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselProducts" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselProducts" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Carousel",
        data(){
            return{
                filterProducts:[],
                filterCategories : [],
                activeCarousel : 0
            }
        },
        methods : {
            showChild(index){
                $('#nested'+index).toggleClass('active');
                $('#parentSpan'+index).toggleClass("caret-down");
            },
            getFilterData(categoryId , parentId){
                if(parentId === null){
                    let customCheckBox = $('#nested'+categoryId).children().children('input');
                    let parenCategory = this.filterCategories.filter(category => category.id === categoryId).shift();
                    if($('#parentCheckbox'+categoryId).is(':checked')){
                        this.$store.commit('addToSelectCategories',categoryId);
                        if(parenCategory.child_category.length > 0){
                                parenCategory.child_category.map( category => {
                                    this.$store.commit('addToSelectCategories',category.id);
                                });
                        }
                        customCheckBox.prop( "checked", true );
                    }else{
                        this.$store.commit('removeFromSelectCategories',categoryId);
                        if(parenCategory.child_category.length > 0){
                            parenCategory.child_category.map( category => this.$store.commit('removeFromSelectCategories',category.id));
                        }
                        customCheckBox.prop( "checked", false );
                    }
                }else {
                    if ($('#childCheckBox' + categoryId).is(':checked')) {
                        this.$store.commit('addToSelectCategories',categoryId);
                        let customCheckBox = $('#nested' + parentId).children().children('input'),
                            checkCount = customCheckBox.filter(':checked').length;
                        if (checkCount === customCheckBox.length) {
                            $('#parentCheckbox' + parentId).prop("checked", true);
                            this.$store.commit('addToSelectCategories',parentId);
                        }
                    }else{
                        this.$store.commit('removeFromSelectCategories',categoryId);
                        this.$store.commit('removeFromSelectCategories',parentId);
                        $('#parentCheckbox' + parentId).prop("checked", false);
                    }
                }
                this.getData();
                axios.post('/getAllProducts' , { 'page' : 1 , 'categories' : this.$store.state.selectCategories})
                    .then((response) => {
                        this.$store.commit('changeProducts',response.data.data) ;
                        this.$store.commit('changeProductLastPage' ,response.data.last_page) ;
                    })
                    .catch(error => console.log(error));
                axios.post('/getAllVideos' , { 'page' : 1 , 'categories' : this.$store.state.selectCategories})
                    .then((response) => {
                        this.$store.commit('changeVideoLastPage' ,response.data.last_page) ;
                        this.$store.commit('changeVideos',response.data.data) ;
                    })
                    .catch(error => console.log(error));
                axios.post('/getAllArticles' , { 'page' : 1 , 'categories' : this.$store.state.selectCategories})
                    .then((response) => {
                        this.$store.commit('changeArticleLastPage' ,response.data.last_page) ;
                        this.$store.commit('changeArticles',response.data.data) ;
                    })
                    .catch(error => console.log(error));
            },
            getData(){
                axios.post('/getProducts' , {'categories' : this.$store.state.selectCategories})
                    .then((response) => {
                        this.filterCategories = response.data.categories;
                        this.filterProducts = response.data.products
                    })
                    .catch(error => console.log(error));
            }
        },
        beforeMount() {
            this.getData()
        },
    }
</script>

<style scoped>
    .main{
        padding: 1% 0 0 2%;
        float: right;
        width : 100%
    }
    .mainCarousel{
        width: 100% !important;
        height: 450px !important;
    }
    .carouselImage{
        width: 100% !important;
        height: 450px !important;
        border-radius: 8px;
    }
    .carousel-inner{
        border-radius: 8px;
    }
    @media screen and (max-width: 768px) {
        .mainCarousel{
            width: 100% !important;
            height: 250px !important;
        }
        .carouselImage{
            width: 100% !important;
            height: 250px !important;
            border-radius: 8px;
        }
    }
    /* tree*/
    ul, #myUL {
        list-style-type: none;
        direction : rtl
    }
    #myUL {
        margin: 0;
        padding: 0;
    }
    #myUL li {
        padding: 1% 0;
    }
    .caret {
        cursor: pointer;
        user-select: none;
        direction : rtl
    }
    .caret::before {
        content: "\25B6";
        color: black;
        display: inline-block;
        margin-right: 6px;
    }
    .caret-down::before {
        transform: rotate(90deg);
    }
    .withoutChild{
        padding-right: 15px;
    }
    .nested {
        display: none;
        padding-right: 10% !important;
    }
    .active {
        display: block;
    }
</style>
