-- KPI1a: Top 5 selling products of the year

DROP PROCEDURE IF EXISTS `Top5SellingProductsofTheYear`;

DELIMITER $$
CREATE PROCEDURE `Top5SellingProductsofTheYear`(IN currentYear INT)
BEGIN
SELECT 
    ROW_NUMBER() OVER (
          -- PARTITION BY `products`.`productLine`
          ORDER BY SUM(`priceEach`) DESC) row_num,
    `orderdetails`.`productCode`,
    `products`.`productName`,
    `products`.`productLine`,
    `products`.`productVendor`,
    `products`.`MSRP`,
    `orders`.`orderDate`,
    COUNT(`orderdetails`.`productCode`) AS countProductCode,
    SUM(`quantityOrdered`) AS sumQuantityOrdered,
    CONCAT(
            `orderdetails`.`productCode`, ": ", `products`.`productName`) AS fullProductDetails,
    SUM(`priceEach`) AS sumPriceEach
FROM
    `orderdetails`
        INNER JOIN
    `orders` ON `orderdetails`.`orderNumber` = `orders`.`orderNumber`
        INNER JOIN
    `products` ON `products`.`productCode` = `orderdetails`.`productCode`
WHERE
    YEAR(`orders`.`orderDate`) = currentYear
        AND (`orders`.`status` = 'Shipped'
        OR `orders`.`status` = 'In Process')
GROUP BY `orderdetails`.`productCode`
ORDER BY SUM(`priceEach`) DESC
LIMIT 0 , 5;
END$$
DELIMITER ;

-- Execute as: 
CALL `Top5SellingProductsofTheYear`(2005);


-- KPI 1b: Year-on-Year Sales Revenue per Month

-- DROP PROCEDURE IF EXISTS `YOYSalesRevenuePerMonth`;

DELIMITER $$
CREATE PROCEDURE `YOYSalesRevenuePerMonth`(IN currentYear INT)
BEGIN
SELECT 
    YEAR(`payments`.`paymentDate`) AS 'paymentYear',
    MONTHNAME(`payments`.`paymentDate`) AS 'paymentMonth',
    SUM(`payments`.`amount`) AS 'salesRevenue'
FROM
    `payments`
WHERE
    YEAR(`payments`.`paymentDate`) IN (currentYear , currentYear - 1)
GROUP BY MONTHNAME(`payments`.`paymentDate`) , YEAR(`payments`.`paymentDate`)
ORDER BY YEAR(`payments`.`paymentDate`) , MONTH(`payments`.`paymentDate`);
END$$
DELIMITER ;

-- Execute as: 
-- CALL `YOYSalesRevenuePerMonth`(2005);