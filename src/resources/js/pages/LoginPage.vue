<template>
    <div>
        <h1>Login</h1>
        <b-form @submit="onSubmit" v-bind:novalidate="true">
            <b-form-input
                id="email"
                v-model="form.email"
                type="email"
                placeholder="Email"
                class="mb-2"
                autocomplete="off"
                required
                v-bind:class="{ 'is-invalid': errors.email || errors.authentication }"
            ></b-form-input>
            <b-form-invalid-feedback id="email-feedback" v-if="errors.email">
                {{ errors.email.join() }}
            </b-form-invalid-feedback>
            <div>
                <b-form-input
                    id="password"
                    v-model="form.password"
                    type="password"
                    placeholder="Password"
                    class="mb-2"
                    autocomplete="off"
                    required
                    v-bind:class="{ 'is-invalid': errors.authentication }"
                ></b-form-input>
                <b-form-invalid-feedback id="password-feedback">
                    {{ errors.authentication }}
                </b-form-invalid-feedback>
            </div>
            <div class="button-container mt-3">
                <b-button type="submit" variant="primary">Submit
                </b-button>
            </div>
        </b-form>
    </div>
</template>


<script>
export default {
    name: "LoginPage",
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            errors: {},
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

            const auth = {email: this.form.email, password: this.form.password};
            window.axios
                .post('/api/user/login', auth)
                .then(response => {
                    this.$store.commit('authenticate', response.data);
                    this.reset();
                    this.$router.push({name: 'index'});
                })
                .catch(error => {
                    this.errors = {authentication:'Email / Password invalid'};
                })
        },
        reset() {
            this.form.email = ''
            this.form.password = ''
        },
        validateForm() {
            const errors = {};
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (false === re.test(this.form.email)) {
                errors.email = ['The email is not valid'];
            }

            return errors;
        },
    },

}
</script>

<style scoped>

</style>
