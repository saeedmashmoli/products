import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
const store = new Vuex.Store({
    state : {
        product: {},
        article: {},
        video : {},
        user : {},
        galleries : [],
        products : [],
        articles : [],
        videos : [],
        comments : [],
        selectCommentId : 0,
        authUser : window.Laravel.authUser ? JSON.parse(window.Laravel.authUser) : {},
        selectCategories : [],
        videoLastPage : '',
        articleLastPage : '',
        productLastPage : '',

    },
    mutations : {
        changeProduct(state , newProduct){
            state.product = newProduct
        },
        changeArticle(state , newArticle){
            state.article = newArticle
        },
        changeVideo(state , newVideo){
            state.video = newVideo
        },
        changeUser(state , newUser){
            state.user = newUser
        },
        changeGalleries(state , newGalleries){
            let myImages = [];
            newGalleries.map(image => myImages.push('/files/products/'+image.product_id+'/640p/'+image.url));
            state.galleries = myImages;
        },
        changeArticles(state , newArticles){
            state.articles = newArticles
        },
        changeProducts(state , newProducts){
            state.products = newProducts
        },
        changeVideos(state , newVideos){
            state.videos = newVideos
        },
        changeVideoLastPage(state , newVideoLastPage){
            state.videoLastPage = newVideoLastPage
        },
        changeArticleLastPage(state , newArticleLastPage){
            state.articleLastPage = newArticleLastPage
        },
        changeProductLastPage(state , newProductLastPage){
            state.productLastPage = newProductLastPage
        },
        addToSelectCategories(state , newCategoryId){
            if (state.selectCategories.indexOf(newCategoryId) === -1 ){
                state.selectCategories.push(newCategoryId)
            }
        },
        removeFromSelectCategories( state , categoryId){
            state.selectCategories = state.selectCategories.filter(category => category !== categoryId)
        },
        addToComments (state , newComment ){
            if(newComment.parent_id > 0){
                state.comments = state.comments.filter( c => c.id !== newComment.id);
            }else{
                state.comments =  state.comments.push(newComment)
            }
        },
        changeComments(state , newComments){
            state.comments = newComments;
        },
        getComments (state , newComments ){
            state.comments = newComments
        },
        changeSelectCommentId(state , newCommentId){
            state.selectCommentId = newCommentId
        },
        changeAuthUser(state , newUser){
            state.authUser = newUser
        }
    }
});
export default store;
