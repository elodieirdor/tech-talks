<template>
    <b-form @submit="onSubmit" v-bind:novalidate="true">
        <b-form-input
            id="topic"
            v-model="form.topic"
            type="text"
            placeholder="Topic"
            class="mb-2"
            autocomplete="off"
            v-bind:class="{ 'is-invalid': errors.topic }"
        ></b-form-input>
        <b-form-invalid-feedback id="topic-feedback" v-if="errors.topic">
            {{ errors.topic.join() }}
        </b-form-invalid-feedback>
        <b-form-text id="topic-help-block">
            80 characters maximum
        </b-form-text>

        <b-form-textarea
            id="description"
            v-model="form.description"
            placeholder="Some few words about this topic..."
            rows="3"
            max-rows="6"
            required
            v-bind:class="{ 'is-invalid': errors.description }"
        ></b-form-textarea>
        <b-form-invalid-feedback id="description-feedback" v-if="errors.description">
            {{ errors.description.join() }}
        </b-form-invalid-feedback>
        <b-form-text id="topic-help-block">
            120 words maximum
        </b-form-text>

        <div>
            <label for="talk_date">Choose a date</label>
            <b-form-datepicker
                id="talk_date"
                v-model="form.date"
                class="mb-2"
                :date-disabled-fn="dateDisabled"
                locale="en"
                v-bind:class="{ 'is-invalid': errors.date }"
            ></b-form-datepicker>
            <b-form-invalid-feedback id="date-feedback" v-if="errors.date">
                {{ errors.date.join() }}
            </b-form-invalid-feedback>

        </div>
        <FormButton :is-loading="isLoading" />
    </b-form>
</template>

<script>
import FormButton from "../ui/FormButton";
export default {
    name: "TalkForm",
    components: {FormButton},
    props: {
        talk: {
            required: false,
        }
    },
    mounted() {
        if (this.talk) {
            this.form = Object.assign({}, this.talk)
        }
    },
    data() {
        const talkDay = 2;

        const now = new Date();
        now.setHours(0);
        now.setMinutes(0);
        now.setSeconds(0);

        const maxDate = new Date(now);
        maxDate.setMonth(now.getMonth() + 6);
        maxDate.setDate(talkDay);

        const minDate = new Date(now);
        minDate.setDate(talkDay);
        if (now > minDate) {
            minDate.setMonth(minDate.getMonth() + 1);
        }

        return {
            maxDate,
            minDate,
            form: {
                topic: "",
                description: "",
                date: "",
            },
            errors: {},
            isLoading: false,
        };

    },
    methods: {
        onSubmit(evt) {
            evt.preventDefault();
            this.errros = {};

            const formErrors = this.validateForm();
            if (Object.keys(formErrors).length > 0) {
                this.errors = Object.assign({}, formErrors);
                return;
            }

            this.isLoading = true;

            const talk = {topic: this.form.topic, description: this.form.description, date: this.form.date};
            let url;
            if (this.talk) {
                url = `api/talks/${this.talk.id}`;
            } else {
                url = '/api/talks';
            }

            const config = {
                headers: {Authorization: `Bearer ${this.$store.state.token}`}
            }
            window.axios
                .post(url, talk, config)
                .then(response => {
                    this.reset();
                    this.$router.push({name: 'user_talks'});
                })
                .catch(error => {
                    if (error.response) {
                        this.errors = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.isLoading = false;
                })
        },
        validateForm() {
            const errors = {};
            if (this.form.topic.length === 0) {
                errors.topic = ['The topic is required'];
            }

            if (this.form.topic.length > 80) {
                errors.topic = ['The topic is too long'];
            }

            if (this.form.description.length === 0) {
                errors.description = ['The description is required'];
            }

            if (this.form.description.split(" ").length > 120) {
                errors.description = ['The description is too long'];
            }

            if (this.form.date === '') {
                errors.date = ['The date is required'];
            }

            return errors;
        },
        reset() {
            this.form.topic = "";
            this.form.description = "";
            this.form.date = '';
        },
        dateDisabled(ymd, date) {
            if (date < this.minDate) {
                return true;
            }

            if (date > this.maxDate) {
                return true;
            }

            if ((date.getMonth() % 2) === 0) {
                return true;
            }

            const weekday = date.getDay();
            const day = date.getDate();

            if (weekday !== 2 || day > 7) {
                return true;
            }

            return false;
        },
    },
}
</script>

<style scoped>

</style>
