<?php namespace LasseRafn\Dinero\Models;

use LasseRafn\Dinero\Builders\PaymentBuilder;
use LasseRafn\Dinero\Requests\PaymentRequestBuilder;
use LasseRafn\Dinero\Utils\Model;

class Invoice extends Model
{
    protected $entity     = 'invoices';
    protected $primaryKey = 'Guid';
    protected $fillable   = [
        'PaymentDate',
        'PaymentStatus',
        'PaymentConditionNumberOfDays',
        'PaymentConditionType',
        'Status',
        'ContactGuid',
        'Guid',
        'TimeStamp',
        'CreatedAt',
        'UpdatedAt',
        'DeletedAt',
        'Number',
        'ContactName',
        'TotalExclVat',
        'TotalVatableAmount',
        'TotalInclVat',
        'TotalNonVatableAmount',
        'TotalVat',
        'TotalLines',
        'Currency',
        'Language',
        'ExternalReference',
        'Description',
        'Comment',
        'Date',
        'ProductLines',
        'Address',
        'Type',
        'TotalInclVatInDkk',
        'TotalExclVatInDkk',
        'MailOutStatus'
    ];

    public $PaymentDate;
    public $PaymentStatus;
    public $PaymentConditionNumberOfDays;
    public $PaymentConditionType;
    public $Status;
    public $ContactGuid;
    public $Guid;
    public $TimeStamp;
    public $CreatedAt;
    public $UpdatedAt;
    public $DeletedAt;
    public $Number;
    public $ContactName;
    public $TotalExclVat;
    public $TotalVatableAmount;
    public $TotalInclVat;
    public $TotalNonVatableAmount;
    public $TotalVat;
    public $Type;
    public $TotalInclVatInDkk;
    public $TotalExclVatInDkk;
    public $MailOutStatus;

    /** @var array */
    public $TotalLines;
    public $Currency;
    public $Language;
    public $ExternalReference;
    public $Description;
    public $Comment;
    public $Date;

    /** @var array */
    public $ProductLines;
    public $Address;

    public function payments()
    {
        return new PaymentRequestBuilder(new PaymentBuilder($this->request, "invoices/{$this->Guid}/payments"));
    }
}