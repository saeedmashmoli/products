<template>
    <div class="w-100" style="background: #6c757d">
        <div class="mainbox">
            <div class="err">4</div>
            <i class="myIcon fa fa-question-circle fa-spin"></i>
            <div class="err2">4</div>
            <div class="msg"><p class="text-white">صفحه مورد نظر یافت نشد!!! </p><router-link class="text-warning" to="/">بازگشت</router-link></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NotFoundPage"
    }
</script>

<style scoped>
    .myIcon{
       color : #ffffff;

    }
    @media screen and (max-width : 640px){
        .err {
            left : 5% !important
        }
        .err2 {
            left: 72% !important;
        }
        .myIcon {
            left: 35% !important;
        }
        .mainbox {
            width: 100% !important;
        }
    }
    body {
        background-color: #6c757d;
    }

    .mainbox {
        background-color: #6c757d;
        margin: auto;
        height: 600px;
        width: 600px;
        position: relative;
    }

    .err {
        color: #ffffff;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 11rem;
        position:absolute;
        left: 20%;
        top: 8%;
    }

    .fa {
        position: absolute;
        font-size: 8.5rem;
        left: 42%;
        top: 15%;
        color: #ffffff;
    }

    .err2 {
        color: #ffffff;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 11rem;
        position:absolute;
        left: 68%;
        top: 8%;
    }

    .msg {
        text-align: center;
        direction: rtl;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 1.6rem;
        position:absolute;
        left: 16%;
        top: 45%;
        width: 75%;
    }

    a {
        text-decoration: none;
        color: white;
    }

    a:hover {
        text-decoration: underline;
    }
</style>
