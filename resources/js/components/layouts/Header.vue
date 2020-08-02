<template>
    <!-- Navigation -->
    <div class="mainHeader">
        <b-navbar toggleable="lg" type="dark" variant="info">
            <b-navbar-brand><router-link to="/">{{Laravel.projectName}}</router-link></b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item><router-link to="/products" class="nav-link">محصولات</router-link></b-nav-item>
                </b-navbar-nav>
                <b-navbar-nav>
                    <b-nav-item><router-link to="/articles"  class="nav-link">مقالات</router-link></b-nav-item>
                </b-navbar-nav>
                <b-navbar-nav>
                    <b-nav-item><router-link to="/videos"  class="nav-link">ویدئوها</router-link></b-nav-item>
                </b-navbar-nav>
                <!-- Right aligned nav items -->
                <b-navbar-nav class="col-lg-6 mr-lg-3">
                    <b-nav-form><search></search></b-nav-form>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>

</template>

<script>
    import Search from "./Search";

    export default {
        name: "Header",
        components: {Search},
        data(){
            return {
                Laravel : window.Laravel,
            }
        },
        methods: {

        }
    }
</script>

<style scoped>
    .mainHeader{
        direction: rtl;
    }
    .form-inline{
        width: 100%;
    }
    .nav-item > a{
        padding: 0;
    }
    .navbar-brand a{
        color: #ccc;
        text-decoration: none;
    }
    .nav-item{
        font-size: 1rem;
    }
    .navbar-brand a:hover{
        color: #fff;
    }
    .navbar-nav form div,.navbar-nav form{
        width: 100%;
    }
    .router-link-active{
        color: #fff !important;
    }
</style>
