<!-- NavBar For Authenticated Users -->
<spark-navbar
        :user="user"
        :teams="teams"
        :current-team="currentTeam"
        :unread-announcements-count="unreadAnnouncementsCount"
        :unread-notifications-count="unreadNotificationsCount"
        inline-template>

    <nav class="navbar navbar-light navbar-expand-md navbar-spark">
        <div class="container" v-if="user">

        @includeIf('spark::nav.user-left')

        <!-- Branding Image -->

        </div>
    </nav>

</spark-navbar>

