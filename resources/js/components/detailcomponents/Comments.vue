<template>
    <div class="col-lg-12 float-right mainCommentDiv">
        <my-comment :commentId="null"></my-comment>
        <div v-for="comment in comments" class="commentDiv" >
            <div>
                <label class="font-weight-bolder">{{comment.user.username}}</label>
                <i class="fa fa-reply mr-3" @click="replayComment(comment.id)"></i>
            </div>
            <div class="mr-3" :id="`commentHeader${comment.id}`">
                <p>{{comment.text}}</p>
                <div v-if="selectCommentId === comment.id">
                    <my-comment :commentId="comment.id"></my-comment>
                </div>
            </div>
            <div v-if="comment.child_comments.length > 0" v-for="childComment in comment.child_comments" class="pr-5 pt-2 float-right w-100">
                <label class="font-weight-bolder">{{childComment.user.username}}</label>
                <p>{{childComment.text}}</p>
            </div>
        </div>

    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import myComment from './Comment';

    export default {
        name: "Comments",
        data(){
            return {
                isReplay : false,
            }
        },
        computed : {
            ...mapState([ 'comments' , 'selectCommentId']),
        },
        components : {
            myComment
        },
        methods : {
            replayComment(commentId){
                this.$store.commit('changeSelectCommentId' , commentId)
            }
        },
    }
</script>

<style scoped>
    .fa-reply{
        cursor : pointer
    }
    .commentDiv{
        margin-top: 1%;
        border: 1px solid #aaa;
        border-radius: 5px;
        padding: 3%;
        background : #ddd;
        float: right;
        width : 100%;
    }
    .mainCommentDiv{
        margin-top: 3%;
        background: #17a2b8;
        padding: 5%;
        border: 1px solid #aaa;
        border-radius: 5px;
    }
</style>
