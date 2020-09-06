<template>
    <div class="button-container mt-3">
        <b-button v-if="!isLoading" :type="type" variant="primary" :class="btnClass" @click="onClickBtn">
            {{ submitText }}
        </b-button>
        <b-button v-else variant="primary" disabled :class="btnClass">
            <b-spinner small type="grow"></b-spinner>
            Loading...
        </b-button>
    </div>
</template>

<script>
export default {
    name: "FormButton",
    props: {
        isLoading: {
            type: Boolean,
            required: true,
        },
        submitText: {
            type: String,
            required: false,
            default: 'Submit',
        },
        type: {
            type: String,
            required: false,
            default: 'submit'
        },
        btnClass: {
            type: String,
            required: false,
            default: ''
        },
        onBtnClick: {
            type: Function,
            required: false,
            default: null
        }
    },
    methods: {
        onClickBtn() {
            this.$emit('onBtnClick')
            return;
        }
    }
}
</script>

<style scoped>

</style>
