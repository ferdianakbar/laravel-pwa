<template>
    <div class="col">
        <div class="card mb-4" :class="[ $root.darkMode ? 'bg-dark' :'']">
            <div class="card-body">
                <div class="small text-muted">{{ getPublishDate }}</div>
                <h2 class="card-title h4">{{ title }}</h2>
                <p class="card-text">{{ shortDescription }}</p>
                <router-link class="btn"
                             :to="{name: 'article', params: {id: id}}"
                             :class="[ $root.darkMode ? 'btn-secondary' :'btn-primary']"
                >Read more →</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "ArticleCard",
    props: {
        title: String,
        publishDate: Date,
        thumbnail: String,
        shortDescription: String,
        id: String
    },
    computed: {
        getPublishDate() {
            return moment(this.publishDate).format('D MMMM YYYY')
        }
    }
}
</script>

<style scoped>

</style>
