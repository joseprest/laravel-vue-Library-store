<template>
    <div>
        <h4 class="text-center">Book Detail</h4>
        <div class="row">
            <div class="col-md-6">
                <v-list class="lighten-3">
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-subtitle>Title</v-list-item-subtitle>
                            <v-list-item-title
                                v-text="book.title"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-subtitle
                                >Description</v-list-item-subtitle
                            >
                            <v-list-item-description
                                v-text="book.description"
                            ></v-list-item-description>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-subtitle>Author</v-list-item-subtitle>
                            <v-list-item-title
                                v-text="book.author"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            book: {},
        };
    },
    mounted() {
        console.log("detail of book");
        this.$axios.get("/sanctum/csrf-cookie").then((response) => {
            this.$axios
                .get(`/api/books/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.book = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        });
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    },
};
</script>
