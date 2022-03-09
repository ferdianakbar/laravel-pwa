<template>
    <footer class="py-3 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; <router-link :to="{name:'home'}">{{$root.siteName}}</router-link> {{ new Date().getFullYear() }}</p></div>
    </footer>
</template>

<script>
export default {
    name: "FooterView"
}
</script>

<style scoped>

</style>
