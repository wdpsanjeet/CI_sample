<!doctype html>
<html lang="en">
<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <tr>
        <td colspan="2" align="center" style="font-size:18px"><b>Invoice</b></td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" cellpadding="5">
                <tr>
                    <td width="65%">
                        To,<br />
                        <b>RECEIVER (BILL TO)</b><br />
                        Name : <?= $seller_org_name ?><br />
                        Billing Address : <?= "-" ?><br />
                    </td>
                    <td width="35%">
                        Invoice No. : <?= $sales_invoice ?><br />
                        Invoice Date : <?= $invoice_date ?><br />
                    </td>
                </tr>
            </table>
            <br />
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th align="left">Sr No.</th>
                    <th align="left">Item Name</th>
                    <th align="left">Quantity</th>
                    <th align="left">Price</th>
                    <th align="left">Actual Amt.</th>
                </tr>
                <?php
                $count = 0;
                foreach ($items as $invoiceItem) {
                    $count++;
                ?>
                    <tr>
                        <td align="left"><?= $count ?></td>
                        <td align="left"><?= $invoiceItem['product_name'] ?></td>
                        <td align="left"><?= $invoiceItem['quantity'] ?></td>
                        <td align="left"><?= $invoiceItem['product_price'] ?></td>
                        <td align="left"><?= $invoiceItem['total_price'] ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td align="right" colspan="5"><b>Sub Total</b></td>
                    <td align="left"><b><?= $total_price ?></b></td>
                </tr>
                <tr>
                    <td align="right" colspan="5"><b>Tax Rate :</b></td>
                    <td align="left"><?= "-" ?></td>
                </tr>
                <tr>
                    <td align="right" colspan="5">Tax Amount: </td>
                    <td align="left"><?= "-" ?></td>
                </tr>
                <tr>
                    <td align="right" colspan="5">Total: </td>
                    <td align="left"><?= $total_price ?></td>
                </tr>
                <tr>
                    <td align="right" colspan="5">Amount Paid:</td>
                    <td align="left"><?= $paid ?></td>
                </tr>
                <tr>
                    <td align="right" colspan="5"><b>Amount Due:</b></td>
                    <td align="left"><?= $dues ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>'