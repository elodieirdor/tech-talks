<template>
    <div>
        <h1>My talks</h1>
        <TalkList :talks="items" :busy="isBusy" :canEdit="true"></TalkList>
    </div>
</template>

<script>
import TalkList from './../components/talk/TalkList'

export default {
    name: "UserTalksPage",
    components: {
        TalkList
    },
    mounted() {
        this.getTalks()
    },
    methods: {
        getTalks() {
            this.isBusy = true;
            const config = {
                headers: {Authorization: `Bearer ${this.$store.state.token}`}
            }
            window.axios
                .get('/api/user/my-talks', config)
                .then(response => {
                    this.items = response.data.data;
                    this.isBusy = false;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    },
    data() {
        return {
            isBusy: false,
            items: [],
        };
    },
};
</script>
