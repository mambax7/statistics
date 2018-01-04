<table width="100%">
    <tr>
        <th>
            <{$lang_stat_hitdetail}> - <{$lang_stat_thissite}>
        </th>
    </tr>
    <tr>
        <td>
            <center>
                <{$lang_stat_werereceived}>:&nbsp;<{$lang_stat_recvtotal}>&nbsp;<{$lang_stat_pageviews}><br>
                <{$lang_stat_todayis}>:&nbsp;<{$lang_stat_nowdate}><br>
                <{$lang_stat_mostmonth}>:&nbsp;<{$lang_stat_mmdata}><br>
                <{$lang_stat_mostday}>:&nbsp;<{$lang_stat_mddata}><br>
                <{$lang_stat_mosthour}>:&nbsp;<{$lang_stat_mhdata}>
            </center>
            <table width="95%" align="center">
                <tr>
                    <th colspan="2"><{$lang_stat_yearlystats}></th>
                </tr>
                <tr>
                    <td width="25%" align="center"><{$lang_stat_yearhead}></td>
                    <td><{$lang_stat_pagesviewed}></td>
                </tr>
                <{foreach item=yearlist from=$yearlist}>
                    <tr>
                        <td width="25%">
                            <{if $yearlist.link eq ""}>
                                <{$yearlist.year}>
                            <{else}>
                                <{$yearlist.link}>
                            <{/if}>
                        </td>
                        <td>
                            <{$yearlist.graph}>&nbsp;<{$yearlist.hits}>&nbsp;(<{$yearlist.percent}>)
                        </td>
                    </tr>
                <{/foreach}>
            </table>
            <table width="95%" align="center">
                <tr>
                    <th colspan="2"><{$lang_stat_monthlystats}></th>
                </tr>
                <tr>
                    <td width="25%" align="center"><{$lang_stat_monthhead}></td>
                    <td><{$lang_stat_pagesviewed}></td>
                </tr>
                <{foreach item=monthlist from=$monthlist}>
                    <tr>
                        <td width="25%">
                            <{if $monthlist.link eq ""}>
                                <{$monthlist.month}>
                            <{else}>
                                <{$monthlist.link}>
                            <{/if}>
                        </td>
                        <td>
                            <{$monthlist.graph}>&nbsp;<{$monthlist.hits}>&nbsp;(<{$monthlist.percent}>)
                        </td>
                    </tr>
                <{/foreach}>
            </table>
            <table width="95%" align="center">
                <tr>
                    <th colspan="2"><{$lang_stat_dailystats}></th>
                </tr>
                <tr>
                    <td width="25%" align="center"><{$lang_stat_dailyhead}></td>
                    <td><{$lang_stat_pagesviewed}></td>
                </tr>
                <{foreach item=dailylist from=$dailylist}>
                    <tr>
                        <td width="25%">
                            <{if $dailylist.link eq ""}>
                                <{$dailylist.date}>
                            <{else}>
                                <{$dailylist.link}>
                            <{/if}>
                        </td>
                        <td>
                            <{$dailylist.graph}>&nbsp;<{$dailylist.hits}>&nbsp;(<{$dailylist.percent}>)
                        </td>
                    </tr>
                <{/foreach}>
            </table>

            <table width="95%" align="center">
                <tr>
                    <th colspan="2"><{$lang_stat_hourlystats}></th>
                </tr>
                <tr>
                    <td width="25%" align="center"><{$lang_stat_hourlyhead}></td>
                    <td><{$lang_stat_pagesviewed}></td>
                </tr>
                <{foreach item=hourlist from=$hourlist}>
                    <tr>
                        <td width="25%">
                            <{$hourlist.hour}>
                        </td>
                        <td>
                            <{$hourlist.graph}>&nbsp;<{$hourlist.hits}>&nbsp;(<{$hourlist.percent}>)
                        </td>
                    </tr>
                <{/foreach}>
            </table>

        </td>
    </tr>
</table>
