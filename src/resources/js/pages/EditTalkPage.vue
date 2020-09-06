<template>
    <div>
        <h1>Talk #{{ $route.params.id }}</h1>
        <TalkForm :talk=talk v-if="talk"/>
    </div>
</template>

<script>
import TalkForm from "../components/talk/TalkForm";

export default {
    name: "EditTalkPage",
    components: {TalkForm},
    data() {
        return {
            talk: null,
        }
    },
    mounted() {
        this.getTalk()
    },
    methods: {
        getTalk() {
            window.axios
                .get(`/api/talks/${this.$route.params.id}`)
                .then(response => {
                    this.talk = response.data.data
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped>

</style>
