<template>
    <div class="container py-5">
        <div class="row">
            <!-- Blog entries-->

            <div class="col-lg-8">
                <div class="row" v-for="article in articles">
                    <ArticleCard :title="article.title" :id="article.id" :publish-date="article.created_at" :short-description="article.short_description"/>
                </div>
            </div>
            <!-- Side widgets-->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import ArticleCard from "../components/ArticleCard";

export default {
    name: "Home",
    components: {ArticleCard},
    data() {
        return {
            page: 1,
            limit: 10,
            total: 0,
            last_page: 1,
            articles: [],
            loggedIn: false
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData: function () {
            let _this = this;
            axios.get('articles', {headers:{'Accept': 'application/json'}})
                .then((res) => {
                    let dataRes = res.data;
                    _.each(dataRes.data, (article, index) => {
                        _this.articles.push(article);
                    });
                });
        }
    }
}
</script>

<style scoped>

</style>
