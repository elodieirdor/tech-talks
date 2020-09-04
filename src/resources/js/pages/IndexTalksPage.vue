<template>
  <div>
    <h1>Upcoming talks</h1>
    <TalkList :talks="items" :busy="isBusy"></TalkList>
  </div>
</template>

<script>
import TalkList from './../components/talk/TalkList'
export default {
  name: "IndexTalksPage",
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
        .get('/api/talks/upcoming')
        .then(response => {
          this.items = response.data;
          this.isBusy = false;
        })
        .catch(error => {
          this.handleApiError(error)
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
