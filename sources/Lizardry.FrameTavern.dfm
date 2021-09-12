object FrameTavern: TFrameTavern
  Left = 0
  Top = 0
  Width = 689
  Height = 144
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object Edit1: TEdit
    Left = 16
    Top = 16
    Width = 89
    Height = 29
    TabOrder = 0
    Text = '0'
  end
  object bbDeposit: TBitBtn
    Left = 16
    Top = 59
    Width = 193
    Height = 33
    Caption = #1050#1091#1087#1080#1090#1100' '#1087#1088#1086#1074#1080#1072#1085#1090
    TabOrder = 1
    OnClick = bbDepositClick
  end
  object bbPrice: TBitBtn
    Left = 223
    Top = 59
    Width = 106
    Height = 33
    Caption = #1062#1077#1085#1099
    TabOrder = 2
    OnClick = bbPriceClick
  end
end
