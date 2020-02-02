<template>
  <div class="login wrapper">
    <md-layout md-row md-align="center">
      <form novalidate @submit.stop.prevent="login()">
        <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.email.$dirty && $v.email.$invalid }">
          <md-icon>mail_outline</md-icon>
          <label>Email</label>
          <md-input v-model.trim="email" 
                    :required="!$v.email.required"
                    @input="$v.email.$touch()"
                    @blur="$v.email.$touch()">
          </md-input>
          <span class="md-error" v-if="!$v.email.email">Email Inválido!</span>
          <span class="md-error" v-if="!$v.email.required">Preenchimento Obrigatório!</span>
        </md-input-container>
        <md-input-container :md-clearable="true" :class="{ 'md-input-invalid': $v.password.$dirty && $v.password.$invalid }">
          <md-icon>vpn_key</md-icon>
          <label>Palavra-Passe</label>
          <md-input type="password" 
                    v-model.trim="password" 
                    :required="!$v.password.required"
                    @input="$v.password.$touch()"
                    @blur="$v.password.$touch()">
          </md-input>
          <span class="md-error" v-if="!$v.password.required">Preenchimento Obrigatório!</span>
        </md-input-container>
        <md-layout md-row md-align="center">
          <md-button type="submit" :disabled="$v.email.$invalid || $v.password.$invalid || formLoading" class="md-raised md-primary">Entrar!</md-button>
          <md-button type="reset" class="md-raised md-accent">Limpar!</md-button>
          <router-link tag="md-button" to="help" class="md-raised md-warn">Ajuda!</router-link>
        </md-layout>
      </form>
    </md-layout>
    <md-layout class="form-loading" md-row md-align="center" v-show="formLoading">
      <md-spinner :md-size="35" md-indeterminate></md-spinner>
    </md-layout>
  </div>
</template>

<script>

import { required, email } from 'vuelidate/lib/validators'
import axios from 'axios'

export default {
  name: 'login',
  data() {
    return {
      email: '',
      password: '',
      formLoading: false
    }
  },
  validations: {
    email: {
      required,
      email
    },
    password: {
      required
    }
  },
  methods: {
    clear() {
      this.email = ''
      this.password = ''
    },
    login() {
      
      this.formLoading = true
  
      const data = {
        email: this.email,
        password: this.password
      }
  
      axios.post('/user/login', data).then(response => {
        
        const data = response.data

        if(data.status != 200) {

          this.$store.commit('addNotification', {
            id: Date.now(),
            type: 'error',
            body: data.error,
            autoClear: false
          })
        
        } else {

          this.clear()

          this.$store.commit('changeUser', data.user)

          return this.$router.push('profile')

        }

        return this.formLoading = false
      
      }).catch(error => {

        this.$store.commit('addNotification', {
          id: Date.now(),
          type: 'error',
          body: error.message,
          autoClear: false
        })

        return this.formLoading = false
      
      })

    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>

  $blue: #2196F3;

  form
  {
    width: 80%;
    margin: 40px 0 0 0;

    .md-input-container
    {
      margin-bottom: 40px;
    }

    .md-layout
    {
      margin-bottom: 20px;

      button
      {
        width: 100%;
        margin: 20px 0 0 0;
        display: block;

        @media (min-width: 601px)
        {
          width: auto;
          margin-right: 10px;
          &:last-child { margin-right: 0; }
        }

      }

    }

  }

  .form-loading
  {
    margin-top: 40px;
  }

</style>
