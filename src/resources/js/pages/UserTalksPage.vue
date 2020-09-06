<template>
    <div>
        <div class="row">
            <div class="col-sm-9"><h1>My talks</h1></div>
            <div class="col-sm-3 text-sm-right">
                <router-link
                    :to="{ name: 'add_talk'}"
                    tag="button"
                    class="btn mr-1 btn-secondary btn-sm"
                >
                    Add
                </router-link>
            </div>
        </div>
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
            window.axios
                .get('/api/user/my-talks')
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
