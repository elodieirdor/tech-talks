<template>
    <div>
        <b-table striped hover :items="talks" :fields="fields" :busy="busy" show-empty>
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
                    class="btn mb-2 btn-secondary btn-sm"
                    v-if="row.item.status !== 'published'"
                >Edit
                </router-link>
                <FormButton :is-loading="isPublishing" submit-text="Publish"
                            type="button"
                            btn-class="btn-success btn-sm"
                            @onBtnClick="publish(row.item.id, row.index)"
                            v-if="row.item.status !== 'published'"/>
                <span v-else>Published</span>
                <div v-if="errors[row.item.id]" class="error-message">{{ errors[row.item.id] }}</div>
            </template>
        </b-table>
    </div>
</template>

<script>
import FormButton from "../ui/FormButton";

export default {
    name: "TalkList",
    components: {FormButton},
    mounted() {
        if (this.canEdit) {
            this.fields.unshift('date');
            this.fields = this.fields.concat(['actions']);
        }
    },
    data() {
        return {
            fields: ["topic", "description"],
            isPublishing: false,
            errors: {},
        };
    },
    methods: {
        publish(id, index) {
            this.isPublishing = true;
            this.errors = {};
            window.axios
                .put(`/api/talks/${id}`)
                .then(response => {
                    this.talks.splice(index, 1, response.data.data)
                })
                .catch(error => {
                    if (error.response) {
                        this.errors[id] = error.response.data.errors.date.join(' ');
                    }
                })
                .finally(() => {
                    this.isPublishing = false;
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

<style scoped>
.error-message {
    width: 100%;
    margin-top: 0.25rem;
    font-size: 80%;
    color: #dc3545;
}
</style>
