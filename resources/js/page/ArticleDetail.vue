<template>
    <div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1">{{ title }}</h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">Posted on {{ getPublishedDate }} by {{ getAuthorName }}
                                <template v-if="bookmarked">
                                    <span v-on:click="unBookmark">
                                        <i class="fa-solid fa-star"></i> Bookmarked
                                    </span>
                                </template>
                                <template v-else>
                                    <span v-on:click="bookmark">
                                        <i class="fa-regular fa-star"></i> Bookmark
                                    </span>
                                </template>
                            </div>
                        </header>
                        <!-- Post content-->
                        <section class="mb-5" v-html="description">

                        </section>
                    </article>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Side widget-->
                    <div class="card mb-4" :class="[$root.darkMode ? 'bg-dark':'']">
                        <div class="card-header" :class="[$root.darkMode ? 'bg-secondary':'']">Side Widget</div>
                        <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import {db} from '../db';

export default {
    name: "ArticleDetail",
    data() {
        return {
            id: undefined,
            title: undefined,
            created_at: undefined,
            description: undefined,
            short_description: undefined,
            author: undefined,
            bookmarked: false
        }
    },
    beforeMount() {
        this.fetch();
    },
    computed: {
        getPublishedDate() {
            return moment(this.created_at).format('D MMMM YYYY')
        },
        getAuthorName() {
            return this.author?.name ? this.author.name : this.author?.email ? this.author?.email : 'unknown'
        }
    },
    methods: {
        fetch: function () {
            let _this = this;
            axios.get('/article/' + _this.$route.params.id)
                .then((res) => {
                    let data = res.data;
                    _this.id = data.id.toString();
                    _this.title = data.title;
                    _this.created_at = data.created_at;
                    _this.description = data.description;
                    _this.short_description = data.short_description;
                    _this.author = data.author;
                    _this.checkBookmark();
                })
                .catch((err) => {
                    let _res = err.response;

                    if (_res.status === 404) {
                        _this.$router.replace({ name: 'notFound' })
                    }
                })
        },
        bookmark: async function (){
            this.bookmarked = true;
            //save bookmark by article id
            await db.bookmarks.add({article_id: this.id});
        },
        unBookmark: async function (){
            this.bookmarked = false;

            //delete bookmark by article id
            await db.bookmarks
                .where("article_id")
                .equals(this.id)
                .delete()
        },
        async checkBookmark() {
            try {
                //check bookmark by article id
                const bookmarked = await db.bookmarks
                    .where("article_id")
                    .equals(this.id)
                    .first();

                if(bookmarked) {
                    this.bookmarked = true;
                }
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>

<style scoped>

</style>
