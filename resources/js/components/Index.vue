<template>
    <div>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a @click="swapComponent('create')" class="btn btn-primary">Add Project</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-2  col-sm-2 col-md-2">
                <div><strong>Title</strong></div>
                <input type="text" v-model="title" v-on:input="getProjects(1)">
            </div>
            <div class="col-xs-2  col-sm-2 col-md-2">
                <div><strong>Organization</strong></div>
                <input type="text" v-model="organization" v-on:input="getProjects(1)">
            </div>
            <div class="col-xs-2  col-sm-2 col-md-2">
                <div><strong>Type</strong></div>
                <input type="text" v-model="filterType" v-on:input="getProjects(1)">
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Organization</th>
                <th>Start</th>
                <th>End</th>
                <th>Role</th>
                <th>Link</th>
                <th>Type</th>
                <th width="280px">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(project, key, index) in projects.data">
                <td>{{ project.id }}</td>
                <td>{{ project.title }}</td>
                <td>{{ project.organization }}</td>
                <td>{{ project.start }}</td>
                <td>{{ project.end }}</td>
                <td>{{ project.role }}</td>
                <td>{{ project.type }}</td>
                <td>{{ project.type }}</td>
                <td>
                    <a class="btn btn-info" href="#">Show</a>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="9">
                    <pagination v-model="page" :records="count.data" :per-page="10"  @paginate="getProjects()"></pagination>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    import axios from 'axios';
    import Pagination from 'vue-pagination-2';

    export default {
        data() {
            return {
                projects: [],
                limit: 10,
                offset: 0,
                count: {data: 0},
                page: 1,
                title: '',
                organization: '',
                filterType: '',
            }
        },
        components: {
            Pagination
        },
        mounted() {
            this.getProjects();
            this.getTotal();
        },
        methods: {
            swapComponent: function(component) {
                this.$root.currentComponent = component;
            },

            getProjects: function (isFilter = false) {
                if (isFilter) {
                    this.page = 1;
                    this.getTotal();
                }

                this.offset = (this.page - 1) * this.limit;

                axios
                    .get('/admin/api/projects/' + this.limit + '/' + this.offset + this.getLink())
                    .then(response => (this.projects = response));
            },

            getTotal: function () {
                var link = '/admin/api/project/count' + this.getLink();

                axios
                    .get(link)
                    .then(response => (this.count = response));
            },

            getLink() {
                var result = '/' + (this.title ? this.title : '0') + '/'
                    + (this.organization ? this.organization : '0') + '/'
                    + (this.filterType ? this.filterType : '0');

                return result;
            },
        },
    }
</script>