<template>
    <div>
        <h1>Register</h1>
        <b-form @submit="onSubmit" v-bind:novalidate="true">
            <b-form-input
                id="email"
                v-model="form.email"
                type="email"
                placeholder="Email"
                class="mb-2"
                autocomplete="off"
                required
                v-bind:class="{ 'is-invalid': errors.email }"
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
                    v-bind:class="{ 'is-invalid': errors.password }"
                ></b-form-input>
                <b-form-text id="password-help-block">
                    Your password must be 8-20 characters long, contain at least 1 uppercase character , 1 lowercase
                    character, 1 digit and a special character.
                </b-form-text>
                <b-form-invalid-feedback id="password-feedback" v-if="errors.password">
                    {{ errors.password.join() }}
                </b-form-invalid-feedback>
            </div>
            <div>
                <b-form-input
                    id="confirm-password"
                    v-model="form.confirmPassword"
                    type="password"
                    placeholder="Confirm Password"
                    class="mb-2"
                    autocomplete="off"
                    required
                    v-bind:class="{ 'is-invalid': errors.confirmPassword }"
                ></b-form-input>
                <b-form-invalid-feedback id="confirm-password-feedback" v-if="errors.confirmPassword">
                    {{ errors.confirmPassword.join() }}
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
    name: "RegisterPage",
    data() {
        return {
            form: {
                email: '',
                password: '',
                confirmPassword: '',
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

            const name = this.form.email.slice(0, this.form.email.indexOf('@'));
            let user = {email: this.form.email, password: this.form.password, name};
            window.axios
                .post('/api/user/register', user)
                .then(response => {
                    this.$store.commit('authenticate', response.data);
                    this.reset();
                    this.$router.push({name: 'index'});
                })
                .catch(error => {
                    if (error.response) {
                        this.errors = error.response.data.errors;
                    }
                })
        },
        reset() {
            this.form.email = ''
            this.form.password = ''
            this.form.confirmPassword = ''
        },
        validateForm() {
            const errors = {};
            if (false === (/[a-z]/g).test(this.form.password) ||
                false === (/[A-Z]/g).test(this.form.password) ||
                false === (/[0-9]/g).test(this.form.password) ||
                false === (/[^a-zA-Z\d]/g).test(this.form.password) ||
                this.form.password.length < 8 ||
                this.form.password.length > 20
            ) {
                errors.password = ['The password does not match the rules'];
            }

            if (this.form.password !== this.form.confirmPassword) {
                errors.confirmPassword = ['The passwords are not the same'];
            }

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
