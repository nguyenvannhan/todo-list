<template>
    <div>
        <h2 class="text-center">
            Hello <strong>{{ this.$auth.user().name }}</strong>
        </h2>
        <p class="text-center" v-if="this.$auth.user().role_id === 1">
            <router-link :to="{ name: 'TaskNew' }" class="btn btn-success"
                >Add New</router-link
            >
        </p>

        <TodoList :user="this.$auth.user()"></TodoList>
    </div>
</template>

<script>
import TodoList from "../components/TodoList";

export default {
    mounted() {
        this.checkParams();
    },
    components: {
        TodoList
    },
    methods: {
        checkParams() {
            if (
                this.$route.params.status &&
                this.$route.params.status != "doing" &&
                this.$route.params.status !== "completed"
            ) {
                this.$router.push("/404");
            }
        }
    }
};
</script>
