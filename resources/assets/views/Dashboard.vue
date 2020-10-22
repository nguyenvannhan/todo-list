<template>
    <div>
        <h2 class="text-center">
            Hello <strong>{{ this.$auth.user().name }}</strong>
        </h2>

        <TodoList :user="this.$auth.user()"></TodoList>
    </div>
</template>

<script>
import TodoList from "../components/TodoList";

export default {
    components: {
        TodoList
    }
};
</script>
