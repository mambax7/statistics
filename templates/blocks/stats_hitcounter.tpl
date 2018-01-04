<table width="100%" align="center">
    <tr>
        <td>
            <table width="99%">
                <tr>
                    <th><{$block.counterhead}></th>
                </tr>
                <tr>
                    <td align="center"><{$block.counter}></td>
                </tr>
            </table>
            <{if $block.display == "all"}>
                <hr>
                <table width="99%">
                    <tr>
                        <th colspan="2"><{$block.yearhead}></th>
                    </tr>
                    <{foreach item=yearhits from=$block.yearhits}>
                        <tr>
                            <td align="left"><b><{$yearhits.year}></b></td>
                            <td align="right"><{$yearhits.counter}></td>
                        </tr>
                    <{/foreach}>
                </table>
            <{/if}>
        </td>
    </tr>
    <{if $block.displayblockedhits == "1"}>
        <tr>
            <td>
                <table width="99%">
                    <tr>
                        <th><{$block.bcounterhead}></th>
                    </tr>
                    <tr>
                        <td align="center"><{$block.bcounter}></td>
                    </tr>
                </table>
                <{if $block.display == "all"}>
                    <hr>
                    <table width="99%">
                        <tr>
                            <th colspan="2"><{$block.byearhead}></th>
                        </tr>
                        <{foreach item=byearhits from=$block.byearhits}>
                            <tr>
                                <td align="left"><b><{$byearhits.year}></b></td>
                                <td align="right"><{$byearhits.counter}></td>
                            </tr>
                        <{/foreach}>
                    </table>
                <{/if}>
            </td>
        </tr>
    <{/if}>
</table>
