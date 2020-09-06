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
<!--                <button-->
<!--                    type="button"-->
<!--                    class="btn btn-success btn-sm"-->
<!--                    @click="publish(row.item.id, row.index)"-->
<!--                    v-if="row.item.status !== 'published'"-->
<!--                >Publish-->
<!--                </button>-->
                <span v-else>Published</span>
            </template>
        </b-table>
    </div>
</template>

<script>
import FormButton from "../ui/FormButton";
let fields = ["topic", "description"]
export default {
    name: "TalkList",
    components: {FormButton},
    data() {
        if (this.canEdit) {
            fields.unshift('date')
            fields = fields.concat(['actions'])
        }
        return {
            fields,
            isPublishing: false
        };
    },
    methods: {
        publish(id, index) {
            this.isPublishing = true;
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
