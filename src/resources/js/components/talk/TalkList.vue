<template>
    <div>
        <b-table striped hover :items="talks" :fields="fields" :busy="busy">
            <template v-slot:table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Loading...</strong>
                </div>
            </template>
            <template v-slot:cell(actions)="row" v-if="canEdit">
                <router-link
                    :to="{ name: 'edit_talk', params: { id: row.item.id }}"
                    tag="button"
                    class="btn mr-1 btn-secondary btn-sm"
                    v-if="row.item.status !== 'published'"
                >Edit
                </router-link>
                <button
                    type="button"
                    class="btn mr-1 btn-success btn-sm"
                    @click="publish(row.item.id, row.index)"
                    v-if="row.item.status !== 'published'"
                >Publish
                </button>
                <span v-else>Published</span>
            </template>
        </b-table>
    </div>
</template>

<script>
let fields = ["topic", "description", "email"]
export default {
    name: "TalkList",
    data() {
        return {
            fields: this.canEdit ? fields.concat(['actions']) : fields,
        };
    },
    methods: {
        publish(id, index) {
            const config = {
                headers: {Authorization: `Bearer ${this.$store.state.token}`}
            }
            window.axios
                .put(`/api/talks/${id}`, {}, config)
                .then(response => {
                    this.talks.splice(index, 1, response.data.data)
                })
                .catch(error => {
                    if (error.response) {
                        this.errors = error.response.data.errors;
                    }
                })
        }
    },
    props: {
        talks: {
            type: Array,
            required: true,
        },
        busy: {
            type: Boolean,
            required: true,
        },
        canEdit: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
