<template>
    <nav v-if="lastPage > 1" class="paginate-nav" aria-label="Page navigation">
        <div class="mt-12">
            <b-pagination-nav
                pills
                v-model="currentPage"
                :number-of-pages="lastPage"
                :link-gen="pageChangeHandler"
                last-number
            ></b-pagination-nav>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Pagination",
        props : ['paginateDetails' , 'pageChangeHandler'],
        data(){
            return {
                currentPage: this.paginateDetails.current_page,
                lastPage : this.paginateDetails.last_page,
            }
        },
    }
</script>

<style scoped>

</style>
