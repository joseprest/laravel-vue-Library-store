<template>
    <v-row>
        <v-col
            v-for="library in libraries"
            :key="library.id"
            lg="4"
            md="6"
            class="mb-4"
        >
            <v-card class="h-100">
                <v-card-title>
                    <router-link :to="`/libraries/${library.id}`">{{
                        library.name
                    }}</router-link>
                </v-card-title>
                <v-card-text>{{ library.books.length }} books</v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data() {
        return {
            libraries: {},
        };
    },
    mounted() {
        this.$axios.get("/sanctum/csrf-cookie").then((response) => {
            this.$axios.get("/api/libraries").then((response) => {
                console.log(response.data);
                this.libraries = response.data;
            });
        });
    },
};
</script>
