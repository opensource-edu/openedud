<template>
        <el-container>
            <el-header>Header</el-header>
            <el-container>
                <navigation></navigation>
                <el-main>
                    <router-view></router-view>
                </el-main>
            </el-container>
        </el-container>
</template>

<script>
import Navigation from './components/NavigationComponent'

export default {
    name: 'app',
    components: {
        'navigation': Navigation,
    }
}
</script>

