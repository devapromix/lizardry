object FrameLogin: TFrameLogin
  Left = 0
  Top = 0
  Width = 676
  Height = 406
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object Panel1: TPanel
    Left = 0
    Top = 0
    Width = 241
    Height = 406
    Align = alLeft
    TabOrder = 0
    ExplicitLeft = 3
    ExplicitTop = 3
    ExplicitHeight = 374
    object Label1: TLabel
      Left = 24
      Top = 21
      Width = 55
      Height = 21
      Caption = #1051#1086#1075#1080#1085
    end
    object Label2: TLabel
      Left = 24
      Top = 88
      Width = 66
      Height = 21
      Caption = #1055#1072#1088#1086#1083#1100
    end
    object edUserName: TEdit
      Left = 24
      Top = 48
      Width = 185
      Height = 29
      MaxLength = 24
      TabOrder = 0
      OnKeyPress = EnterKeyPress
    end
    object bbLogin: TBitBtn
      Left = 24
      Top = 160
      Width = 75
      Height = 33
      Caption = #1042#1093#1086#1076
      TabOrder = 2
      OnClick = bbLoginClick
    end
    object bbRegistration: TBitBtn
      Left = 24
      Top = 256
      Width = 137
      Height = 33
      Caption = #1056#1077#1075#1080#1089#1090#1088#1072#1094#1080#1103
      TabOrder = 3
      OnClick = bbRegistrationClick
    end
    object edUserPass: TEdit
      Left = 24
      Top = 115
      Width = 185
      Height = 29
      MaxLength = 24
      PasswordChar = '*'
      TabOrder = 1
      OnKeyPress = EnterKeyPress
    end
  end
end
