<template>
    <div class="container py-3">
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <p class="alert alert-secondary">
                            If you have any questions just send a message in the form below.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="$refs.reCaptcha.verify">
                                    <div class="form-group">
                                        <label for="email">Email
                                            <small>Required</small>
                                        </label>
                                        <input type="email"
                                               required
                                               id="email"
                                               class="form-control"
                                               v-model.trim="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name
                                            <small>Required</small>
                                        </label>
                                        <input type="text"
                                               required
                                               id="name"
                                               class="form-control"
                                               v-model.trim="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">Subject
                                            <small>Required</small>
                                        </label>
                                        <input type="text"
                                               required
                                               id="subject"
                                               class="form-control"
                                               v-model.trim="subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Message
                                            <small>Required</small>
                                        </label>
                                        <textarea id="message"
                                                  required
                                                  class="form-control"
                                                  v-model.trim="message"
                                                  rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <re-captcha ref="reCaptcha" @verified="contactMe"></re-captcha>
                                    </div>
                                    <button :disabled="loading" type="submit" class="btn btn-secondary">Send</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ReCaptcha from "../utils/re-captcha";
    import {GotoMixin, MetaMixin} from "../../mixins";

    export default {
        components: {
            ReCaptcha,
        },
        mixins: [
            GotoMixin,
            MetaMixin,
        ],
        data: function () {
            return {
                loading: false,
                email: "",
                name: "",
                subject: "",
                message: "",
            };
        },
        computed: {
            pageTitle: function () {
                return "Contact Me";
            },
        },
        methods: {
            contactMe: async function (reCaptchaResponse) {
                this.loading = true;
                try {
                    await this.$dc.get("api").createContactMessage({
                        email: this.email,
                        name: this.name,
                        subject: this.subject,
                        message: this.message,
                        g_recaptcha_response: reCaptchaResponse,
                    });
                    this.$dc.get("notification").success("Your message has been successfully sent.");
                    this.goToHomePage();
                } finally {
                    this.loading = false;
                }
            },
        },
    }
</script>
