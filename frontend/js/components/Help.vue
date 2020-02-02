<template>
  <div class="help">
      <md-layout class="help-tabs">
        <md-tabs md-fixed>
            <md-tab md-label="Password" md-icon="vpn_key">
                <h1 md-title>Esqueci-me da Palavra-Passe!</h1>
                <form novalidate @submit.stop.prevent="recoverPassword()">
                    <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.forgotPassword.email.$dirty && $v.forgotPassword.email.$invalid }">
                        <label>Email</label>
                        <md-input v-model.trim="forgotPassword.email" 
                                  :required="!$v.forgotPassword.email.required"
                                  @input="$v.forgotPassword.email.$touch()"
                                  @blur="$v.forgotPassword.email.$touch()">
                        </md-input>
                        <span class="md-error" v-if="!$v.forgotPassword.email.email">Email Inválido!</span>
                        <span class="md-error" v-if="!$v.forgotPassword.email.required">Preenchimento Obrigatório!</span>
                    </md-input-container>
                    <md-layout class="buttons-container">
                        <div class="buttons">
                            <md-button type="submit" :disabled="$v.forgotPassword.$invalid || formLoading" class="md-raised md-primary">Enviar!</md-button>
                        </div>
                        <md-spinner :md-size="30" md-indeterminate class="formLoading" v-if="formLoading"></md-spinner>
                    </md-layout>
                </form>
            </md-tab>
            <md-tab md-label="Activação" md-icon="account_box">
                <h1 md-title>Reenviar email de activação!</h1>
                <form novalidate @submit.stop.prevent="resendActivationEmail()">
                    <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.newActivation.email.$dirty && $v.newActivation.email.$invalid }">
                        <label>Email</label>
                        <md-input v-model.trim="newActivation.email" 
                                  :required="!$v.newActivation.email.required"
                                  @input="$v.newActivation.email.$touch()"
                                  @blur="$v.newActivation.email.$touch()">
                        </md-input>
                        <span class="md-error" v-if="!$v.newActivation.email.email">Email Inválido!</span>
                        <span class="md-error" v-if="!$v.newActivation.email.required">Preenchimento Obrigatório!</span>
                    </md-input-container>
                    <md-layout class="buttons-container">
                        <div class="buttons">
                            <md-button type="submit" :disabled="$v.newActivation.$invalid || formLoading" class="md-raised md-primary">Enviar!</md-button>
                        </div>
                        <md-spinner :md-size="30" md-indeterminate class="formLoading" v-if="formLoading"></md-spinner>
                    </md-layout>
                </form>
            </md-tab>
            <md-tab md-label="Contacto" md-icon="contact_phone">
                <h1 md-title>Fale connosco!</h1>
                <form novalidate @submit.stop.prevent="contact()">
                    <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.contactForm.email.$dirty && $v.contactForm.email.$invalid }">
                        <label>Email</label>
                        <md-input v-model.trim="contactForm.email" 
                                  :required="!$v.contactForm.email.required"
                                  @input="$v.contactForm.email.$touch()"
                                  @blur="$v.contactForm.email.$touch()">
                        </md-input>
                        <span class="md-error" v-if="!$v.contactForm.email.email">Email Inválido!</span>
                        <span class="md-error" v-if="!$v.contactForm.email.required">Preenchimento Obrigatório!</span>
                    </md-input-container>
                    <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.contactForm.name.$dirty && $v.contactForm.name.$invalid }">
                        <label>Nome</label>
                        <md-input v-model.trim="contactForm.name" 
                                  :required="!$v.contactForm.name.required"
                                  @input="$v.contactForm.name.$touch()"
                                  @blur="$v.contactForm.name.$touch()">
                        </md-input>
                        <span class="md-error" v-if="!$v.contactForm.name.required">Preenchimento Obrigatório!</span>
                    </md-input-container>
                    <md-input-container>
                        <label for="subject">Assunto</label>
                        <md-select id="subject" v-model="contactForm.subject">
                            <md-option value="premium">Premium</md-option>
                            <md-option value="account">Contas</md-option>
                            <md-option value="doubts">Dúvidas</md-option>
                            <md-option value="suggestions">Sugestões</md-option>
                            <md-option value="other">Outro</md-option>
                        </md-select>
                    </md-input-container>
                    <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.contactForm.text.$dirty && $v.contactForm.text.$invalid }">
                        <label>Texto</label>
                        <md-input v-model.trim="contactForm.text" 
                                  :required="!$v.contactForm.text.required"
                                  :minLength="!$v.contactForm.text.minLength"
                                  :maxLength="!$v.contactForm.text.maxLength"
                                  @input="$v.contactForm.text.$touch()"
                                  @blur="$v.contactForm.text.$touch()">
                        </md-input>
                        <span class="md-error" v-if="!$v.contactForm.text.required">Preenchimento Obrigatório!</span>
                        <span class="md-error" v-if="!$v.contactForm.text.minLength">O texto deve ter no mínimo {{ $v.contactForm.text.$params.minLength.min }} caractéres.</span>
                        <span class="md-error" v-if="!$v.contactForm.text.maxLength">O texto só pode ter no máximo {{ $v.contactForm.text.$params.maxLength.min }} caractéres.</span>
                    </md-input-container>
                    <md-layout class="buttons-container">
                        <div class="buttons">
                            <md-button type="submit" :disabled="$v.contactForm.$invalid || formLoading" class="md-raised md-primary">Enviar!</md-button>
                            <md-button type="reset" class="md-raised md-accent">Limpar!</md-button>
                        </div>
                        <md-spinner :md-size="30" md-indeterminate class="formLoading" v-if="formLoading"></md-spinner>
                    </md-layout>
                </form>
            </md-tab>
        </md-tabs>
      </md-layout>
  </div>
</template>

<script>

import { required, email, minLength, maxLength } from 'vuelidate/lib/validators'
import axios from 'axios'

export default {
    name: 'help',
    data() {
        return {
            forgotPassword: {
                email: '',
                catcher: ''
            },
            newActivation: {
                email: '',
                catcher: ''
            },
            contactForm: {
                email: '',
                name: '',
                subject: 'premium',
                text: '',
                catcher: ''
            },
            formLoading: false
        }
    },
    validations: {
        forgotPassword: {
            email: {
                required,
                email
            }
        },
        newActivation: {
            email: {
                required,
                email
            }
        },
        contactForm: {
            email: {
                required,
                email
            },
            name: {
                required
            },
            text: {
                required,
                minLength: minLength(10),
                maxLength: maxLength(5000)
            }
        }
    },
    methods: {
        recoverPassword() {

            this.formLoading = true

            const data = {
                email: this.forgotPassword.email
            }

            axios.post('/user/recover/password', data).then(response => {

                const data = response.data

                if(data.status != 200) {

                    this.$store.commit('addNotification', {
                        id: Date.now(),
                        type: 'info',
                        body: data.message,
                        autoClear: true
                    })

                    return this.formLoading = false

                } else {

                    this.$store.commit('addNotification', {
                        id: Date.now(),
                        type: 'success',
                        body: data.message,
                        autoClear: true
                    })

                    this.forgotPassword.email = ''

                    return this.formLoading = false

                }

            }).catch(error => {
                
                this.$store.commit('addNotification', {
                    id: Date.now(),
                    type: 'error',
                    body: error.message,
                    autoClear: false
                })

                return this.formLoading = false

            })

        },
        resendActivationEmail() {

            this.formLoading = true

            const data = {
                email: this.newActivation.email
            }

            axios.post("/user/activation/resend", data).then(response => {

                const data = response.data

                if(data.status != 200) {

                    this.$store.commit('addNotification', {
                        id: Date.now(),
                        type: 'info',
                        body: data.message,
                        autoClear: true
                    })

                    return this.formLoading = false

                } else {

                    this.$store.commit('addNotification', {
                        id: Date.now(),
                        type: 'success',
                        body: data.message,
                        autoClear: true
                    })

                    this.newActivation.email = ''

                    return this.formLoading = false

                }

            }).catch(error => {

                this.$store.commit('addNotification', {
                    id: Date.now(),
                    type: 'error',
                    body: error.message,
                    autoClear: false
                })

                return this.formLoading = false

            })

        },
        contact() {

            this.formLoading = true

            const data = {
                email: this.contactForm.email,
                name: this.contactForm.name,
                subject: this.contactForm.subject,
                text: this.contactForm.text,
            }

            axios.post('/user/contact', data).then(response => {

                const data = response.data

                if(data.status != 200) {

                    this.$store.commit('addNotification', {
                        id: Date.now(),
                        type: 'info',
                        body: data.message,
                        autoClear: true
                    })

                    return this.formLoading = false

                } else {

                    this.$store.commit('addNotification', {
                        id: Date.now(),
                        type: 'success',
                        body: data.message,
                        autoClear: true
                    })

                    this.clearForm()

                    return this.formLoading = false

                }

            }).catch(error => {

                this.$store.commit('addNotification', {
                    id: Date.now(),
                    type: 'error',
                    body: error.message,
                    autoClear: false
                })

                return this.formLoading = false

            })

        },
        clearForm() {
            this.contactForm.email = ''
            this.contactForm.name = ''
            this.contactForm.subject = 'premium'
            this.contactForm.text = ''
        }
    }
}
</script>

<style lang="scss" scoped>

.help
{
    display: flex;
    flex-direction: column;
    height: 100%;

    h1
    {
        margin: 0 0 10px 0;
    }

    .help-tabs
    {
        flex: 1;

        .buttons-container
        {
            align-items: center;

            .buttons
            {
                flex: 1;
            }

            button
            {
                margin: 6px 0 0 0;
            }

            button[type='reset']
            {
                margin-left: 5px;
            }

            @media (max-width: 600px)
            {
                justify-content: center;
            }
        }

    }

}

</style>

