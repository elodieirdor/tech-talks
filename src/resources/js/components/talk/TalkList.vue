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
                >Edit
                </router-link>
                <router-link
                    :to="{ name: 'edit', params: { id: row.item.id }}"
                    tag="button"
                    class="btn mr-1 btn-success btn-sm"
                >Publish
                </router-link>
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
