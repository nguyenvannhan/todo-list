<template>
    <div class="c-app flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol md="4">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardBody>
                                <CForm @submit.prevent="login">
                                    <h1>Login</h1>
                                    <p class="text-muted">
                                        Sign In to your account
                                    </p>
                                    <div
                                        class="alert alert-danger"
                                        v-if="hasError"
                                    >
                                        <p>
                                            Login Failed!
                                        </p>
                                    </div>
                                    <CInput
                                        placeholder="Email"
                                        autocomplete="username email"
                                        v-model="email"
                                    >
                                        <template #prepend-content
                                            ><CIcon name="cil-user"
                                        /></template>
                                    </CInput>
                                    <CInput
                                        placeholder="Password"
                                        type="password"
                                        v-model="password"
                                        autocomplete="curent-password"
                                    >
                                        <template #prepend-content
                                            ><CIcon name="cil-lock-locked"
                                        /></template>
                                    </CInput>
                                    <CRow>
                                        <CCol col="6" class="text-left">
                                            <CButton
                                                color="primary"
                                                class="px-4"
                                                type="submit"
                                                >Login</CButton
                                            >
                                        </CCol>
                                    </CRow>
                                </CForm>
                            </CCardBody>
                        </CCard>
                    </CCardGroup>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>

<script>
export default {
    name: "Login",

    data() {
        return {
            email: "",
            password: "",
            hasError: false
        };
    },

    methods: {
        login() {
            this.$auth
                .login({
                    data: {
                        email: this.email,
                        password: this.password
                    },
                    rememberMe: true,
                    fetchUser: true
                })
                .then(res => {
                    this.$router.push({ name: "Todo" });
                })
                .catch(err => {
                    this.hasError = true;
                });
        }
    }
};
</script>
